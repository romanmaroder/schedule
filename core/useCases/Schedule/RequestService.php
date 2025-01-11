<?php

namespace core\useCases\Schedule;

class RequestService
{
    public function dataRangeParams(string $fromDate,string $toDate): array
    {
        if ($request = \Yii::$app->request->post()) {
            $params = [
                $fromDate => $request[$fromDate],
                $toDate => $request[$toDate]
            ];
        } else {
            $params = [
                $fromDate => Date('Y-m-d'),
                $toDate => Date('Y-m-d')
            ];
        }
        return $params;
    }
}