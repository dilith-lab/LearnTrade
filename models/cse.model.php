<?php

class CSE extends DBconn
{
    // Fetch stock data from CSE API
    protected function getCompanyStockSummary($symbol)
    {
        $url = "https://www.cse.lk/api/companyInfoSummery";

        // Setup cURL options
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['symbol' => $symbol]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/x-www-form-urlencoded"
        ]);

        $result = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            echo "cURL error: " . curl_error($ch);
            return null;
        }

        curl_close($ch);

        return $result ? json_decode($result, true) : null;
    }
}
