<?php
require_once __DIR__ . "/../models/cse.model.php";

class CSEContr extends CSE
{
    // Fetch stock summary from API
    public function fetchStockData($symbol)
    {
        // Fetch stock summary from API
        $stockSummary = $this->getCompanyStockSummary($symbol);

        // Check if the API returned valid data
        if ($stockSummary && isset($stockSummary['reqSymbolInfo'])) {
            return [
                'symbol' => $symbol,
                'company_name' => $stockSummary['reqSymbolInfo']['name'],
                'last_trade_price' => $stockSummary['reqSymbolInfo']['lastTradedPrice'],
                'closing_price' => $stockSummary['reqSymbolInfo']['closingPrice'],
                'previous_close' => $stockSummary['reqSymbolInfo']['previousClose'],
                'high_price' => $stockSummary['reqSymbolInfo']['hiTrade'],
                'low_price' => $stockSummary['reqSymbolInfo']['lowTrade'],
                'change' => $stockSummary['reqSymbolInfo']['change'],
                'change_percentage' => $stockSummary['reqSymbolInfo']['changePercentage'],

                'company_logo' => $stockSummary['reqLogo']['path'],
            ];
        }

        return null; // Return null if no valid data is retrieved
    }
}
