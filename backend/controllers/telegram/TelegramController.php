<?php


namespace backend\controllers\telegram;


use core\readModels\Schedule\EventReadRepository;
use core\readModels\User\UserReadRepository;
use core\services\bots\classes\telegram\TelegramBot;
use core\services\messengers\Greeting;
use core\services\messengers\MessageTemplates;
use core\useCases\manage\UserManageService;
use Telegram\Bot\Keyboard\Keyboard;
use yii\filters\AccessControl;
use yii\web\Controller;

class TelegramController extends Controller
{
    private TelegramBot $bot;
    private $update;
    private $service;
    private $repository;
    private $events;
    private $message;

    public function __construct( $id, $module, UserManageService $service, UserReadRepository $repository, EventReadRepository $events, MessageTemplates $message, $config = [])
    {
        $this->bot = new TelegramBot();
        $this->update = $this->bot->commandsHandler(true);
        $this->service = $service;
        $this->repository = $repository;
        $this->events = $events;
        $this->message = $message;

        parent::__construct($id, $module, $config);
    }

    /* Обязательно нужно отключить Csr валидацию, так не будет работать */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = ($action->id !== "webhook");
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['webhook'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
        ];
    }

    public function actionWebhook()
    {

        file_put_contents(__DIR__ . '/logs.txt', print_r($this->update, 1), FILE_APPEND);


        if ($this->update->isType('callback_query')) {
            $this->address();
            $this->phone();
            $this->events();
            $this->event();
        }

        if ($this->update->isType('message')) {
            /* START */
            if ($this->update->message->text === '/start') {
                if ($user = $this->repository->findByChatId($this->update->message->chat->id)) {
                    $this->bot->sendMessage(
                        [
                            'chat_id' => $this->update->message->chat->id,
                            'text' => Greeting::checkGreeting() . "<b><i>$user->username</i></b>, что Вы хотите узнать?",
                            'parse_mode' => 'HTML',
                            'reply_markup' => $this->keyboardStart()
                        ]
                    );
                } else {
                    $this->bot->sendMessage(
                        [
                            'chat_id' => $this->update->message->chat->id,
                            'text' => 'Нажмите кнопку <b>ОТПРАВИТЬ НОМЕР</b>, чтобы найти Ваши записи.',
                            'entities' => ['type' => 'phone_number'],
                            'parse_mode' => 'HTML',
                            'reply_markup' => $this->keyboardLoginStart()
                        ]
                    );
                }
                /* HELP */
            }
            elseif ($this->update->message->text === '/help') {
                $this->bot->sendMessage(
                    [
                        'chat_id' => $this->update->message->chat->id,
                        'text' => 'Инструкции',
                        'reply_markup' => $this->keyboardHelp()
                    ]
                );
                /* BUTTON CONTACT */
            }
            /* BUTTON CONTACT */
            elseif (isset($this->update->message->contact)) {
                $user = $this->repository->findByUserPhone($this->bot->convertPhone(trim($this->update->message->contact['phone_number'])));

                if ($this->isUser($user)) {
                    $this->service->attachTelegram($user->id,$this->update->message->chat->id,$this->update->message->from->firstName ?? $this->update->message->from->username,);

                    $replyMarkup = $this->keyboardStart();
                } else {
                    $replyMarkup = Keyboard::forceReply(['selective' => true]);
                }

                $this->bot->sendMessage(
                    [
                        'chat_id' => $this->update->message->chat->id,
                        'text' => $user->username ?? $this->update->message->from->firstName .", введите номер с которого звоните мастеру.\nФормат телефона <code>+79499999999</code>\nБез скобок, пробелов, дефисов",
                        'reply_markup' => $replyMarkup,
                        'parse_mode' => 'HTML'
                    ]
                );
            }
            /* ENTERING A NUMBER MANUALLY */
            elseif (isset($this->update->message->text)) {
                $user = $this->repository->findByUserPhone($this->bot->convertPhone(trim($this->update->message->text)));
                if ($this->isUser($user)) {
                    $this->service->attachTelegram($user->id,$this->update->message->chat->id,$this->update->message->from->firstName ?? $this->update->message->from->username,);
                    $text = '<b>'.$user->username.'</b>'. ', что хотите узнать?';
                    $replyMarkup = $this->keyboardStart();
                } else {
                    $text ="По этому номеру записи не найдены. \nВозможно Вы ошиблись.";
                    $replyMarkup = Keyboard::forceReply(['selective' => true]);
                }
                $this->bot->sendMessage(
                    [
                        'chat_id' => $this->update->message->chat->id,
                        'text' => $text,
                        'parse_mode' => 'HTML',
                        'reply_markup' => $replyMarkup
                    ]
                );
            }
        }
    }

    private function address()
    {
        if ($this->update->callbackQuery->data === 'ADDRESS') {
            $this->bot->sendMessage(
                [
                    'chat_id' => $this->update->callbackQuery->message->chat->id,
                    'text' => $this->message->checkMessage('Address','',false),
                ]
            );
        }
    }

    private function phone()
    {
        if ($this->update->callbackQuery->data === 'PHONE') {
            $this->bot->sendMessage(
                [
                    'chat_id' => $this->update->callbackQuery->message->chat->id,
                    'text' => "При первом запуске, бот попросит отправить номер телефона. Если номер отличается от номера по которому Вы звоните мастеру, бот попросит написать номер. \n",
                ]
            );
        }
        if ($this->update->callbackQuery->data === 'FORMAT') {
            $this->bot->sendMessage(
                [
                    'chat_id' => $this->update->callbackQuery->message->chat->id,
                    'text' => "Формат телефона <code>+79499999999</code>\nБез скобок, пробелов, дефисов",
                    'parse_mode' => 'HTML'
                ]
            );
        }
    }

    private function events()
    {
        if ($this->update->callbackQuery->data === 'EVENTS') {
            $user = $this->repository->findByChatId($this->update->callbackQuery->message->chat->id);
            if ($events = $this->events->findAllClientEvents($user->id)) {
                foreach ($events as $item) {
                    $this->bot->sendMessage(
                        [
                            'chat_id' => $this->update->callbackQuery->message->chat->id,
                            'text' => "<b>" . \Yii::$app->formatter->asDatetime(
                                    $item['start'],
                                    'php:d M Y на H:i'
                                ) . "</b>\n",
                            'reply_markup' => Keyboard::make()
                                ->inline()
                                ->row(
                                    [
                                        Keyboard::inlineButton(
                                            [
                                                'text' => 'ПОДРОБНЕЕ',
                                                'callback_data' => $item['id']
                                            ]
                                        ),
                                    ]
                                ),
                            'parse_mode' => 'HTML'
                        ]
                    );
                }
            } else {
                $this->bot->sendMessage(
                    [
                        'chat_id' => $this->update->callbackQuery->message->chat->id,
                        'text' => "Вы еще не записались.",
                    ]
                );
            }
        }
    }

    private function event()
    {
        if ($this->update->callbackQuery->data) {
            if ($event = $this->events->findOneClientEvent($this->update->callbackQuery->data)) {
                $list = '';
                foreach ($event['services'] as $service) {
                    $list .= $service['name'] . " - " . $service['price_new'] . "\n";
                }
                $this->bot->sendMessage(
                    [
                        'chat_id' => $this->update->callbackQuery->message->chat->id,
                        'text' => "<b>" . \Yii::$app->formatter->asDatetime(
                                $event['start'],
                                'php:d M Y на H:i'
                            ) . "</b>\n\n" . $list,
                        'reply_markup' => Keyboard::make()
                            ->inline()
                            ->row(
                                [
                                    Keyboard::inlineButton(
                                        [
                                            'text' => 'ЗАПИСИ',
                                            'callback_data' => 'EVENTS'
                                        ]
                                    )
                                ]
                            ),
                        'parse_mode' => 'HTML'
                    ]
                );
            }
        }
    }

    private function keyboardStart(): Keyboard
    {
        return Keyboard::make()
            ->inline()
            ->row(
                [
                    Keyboard::inlineButton(
                        [
                            'text' => 'АДРЕС',
                            'callback_data' => 'ADDRESS'
                        ]
                    ),
                    Keyboard::inlineButton(
                        [
                            'text' => 'ЗАПИСИ',
                            'callback_data' => 'EVENTS'
                        ]
                    )
                ]
            );
    }

    private function keyboardLoginStart(): Keyboard
    {
        return Keyboard::make()
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->row(
                [
                    Keyboard::Button(
                        [
                            'text' => 'ОТПРАВИТЬ НОМЕР',
                            'request_contact' => true
                        ]
                    ),
                ]
            );
    }

    private function keyboardHelp(): Keyboard
    {
        return Keyboard::make()
            ->inline()
            ->row(
                [
                    Keyboard::inlineButton(
                        [
                            'text' => 'ОТПРАВИТЬ ТЕЛЕФОН',
                            'callback_data' => 'PHONE'
                        ]
                    ),
                    Keyboard::inlineButton(
                        [
                            'text' => 'ФОРМАТ ТЕЛЕФОНА',
                            'callback_data' => 'FORMAT'
                        ]
                    )
                ]
            );
    }

    private function isUser($user): bool
    {
        if (!$user) {
            return false;
        }
        return true;
    }


}