<?php


namespace core\services\bots\classes\telegram;

use core\helpers\BotLogger;
use core\readModels\User\UserReadRepository;
use core\services\bots\interfaces\BotInterface;
use core\services\messengers\MessageTemplates;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Keyboard\Keyboard;

/**
 * @method 'botLogger' - logging exceptions when a user blocks a bot
 */
class Event implements BotInterface
{
    private UserReadRepository $repositories;
    private TelegramBot $bot;
    private MessageTemplates $message;

    public function __construct()
    {
        $this->repositories = new UserReadRepository();
        $this->bot = new TelegramBot();
        $this->message = new MessageTemplates();
    }

    public function send($params)
    {
        $user = $this->setReceiver($params);

        $this->botLogger($exception = null);

        if ($user->isChatId()) {
            try {
                $this->bot->sendMessage(
                    [
                        'chat_id' => $user->t_chat_id,
                        'text' => $this->message->checkMessage('Remind', $params),
                        'parse_mode' => 'HTML',
                        'reply_markup' => Keyboard::make()
                            ->setResizeKeyboard(true)
                            ->setOneTimeKeyboard(true)
                            ->row(
                                [
                                    Keyboard::button(
                                        [
                                            'text' => 'TEST',
                                            'request_contact' => true,
                                            'request_location'=>true
                                        ]
                                    ),
                                ]
                            )
                    ]
                );

                $this->botLogger($exception = null);
            } catch (TelegramSDKException $e) {
                $this->botLogger(
                    $exception = [
                        'code' => $e->getCode(),
                        'message' => $e->getMessage(),
                        'chat_id' => $user->t_chat_id,
                        'username' => $this->bot->getChat(
                                ['chat_id' => $user->t_chat_id]
                            )->lastName ?? $this->bot->getChat(
                                ['chat_id' => $user->t_chat_id]
                            )->firstName,
                        'webhook' => $this->bot->getWebhookInfo(),

                    ]
                );
            }
        }
        return null;
    }

    private function setReceiver($recipient)
    {
        return $this->repositories->find($recipient->client_id);
    }

    private function botLogger($exception)
    {
        BotLogger::Logger(__DIR__ . '../../../log.txt', $exception);
    }
}