<?php

namespace core\useCases\Schedule;

class RequestService
{
    /**
     * @param string $fromDate
     * @param string $toDate
     * @param bool $defaultDate
     * @return array|null[]
     */
    public function dataRangeParams(string $fromDate, string $toDate, bool $defaultDate = true): array
    {
        $date = Date('Y-m-d');
        if ($request = \Yii::$app->request->post()) {
            $params = [
                $fromDate => $request[$fromDate],
                $toDate => $request[$toDate]
            ];
        } else {
            $params = [
                $fromDate => $defaultDate ? $date : null,
                $toDate => $defaultDate ? $date : null,
            ];
        }
        return $params;
    }
}