<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AdminController;
use App\Helpers\OpenAIClient;
use App\Models\Product;
use App\Models\Category;
use App\Models\Transaction;

class AssistantController extends AdminController
{
    public function index()
    {
        $this->view->layout('admin');
        $this->view('admin/assistant/index', [
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'AI Assistant']
            ]
        ]);
    }

    public function sandbox()
    {
        $this->view->layout('admin');
        $this->view('admin/assistant/sandbox', [
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'AI Assistant', 'url' => url('admin/assistant')],
                ['label' => 'AI Sandbox']
            ]
        ]);
    }

    public function runSandbox()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            flash('error', 'Invalid request method.');
            $this->redirect('/admin/assistant/sandbox');
            return;
        }

        $startDate = $_POST['start_date'] ?? null;
        $endDate = $_POST['end_date'] ?? null;
        $customPrompt = $_POST['custom_prompt'] ?? '';

        if (!$startDate || !$endDate) {
            flash('error', 'Please select a date range.');
            $this->redirect('/admin/assistant/sandbox');
            return;
        }

        if (empty(trim($customPrompt))) {
            flash('error', 'Please provide instructions for the AI.');
            $this->redirect('/admin/assistant/sandbox');
            return;
        }

        $transactions = Transaction::query()
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->orderBy('date', 'ASC')
            ->get();

        if (empty($transactions)) {
            flash('error', 'No transactions found for the selected period.');
            $this->redirect('/admin/assistant/sandbox');
            return;
        }

        try {
            $client = OpenAIClient::fromEnv();
            $systemPrompt = "You are a helpful business assistant with expertise in data analysis, financial analysis, and business insights. Analyze the provided transaction data and respond to the user's request with clear, actionable insights.";
            $userPrompt = $this->buildSandboxPrompt($transactions, $customPrompt, $startDate, $endDate);

            $response = $client->chat([
                ["role" => "system", "content" => $systemPrompt],
                ["role" => "user", "content" => $userPrompt]
            ]);

            $aiResponse = $response['choices'][0]['message']['content'] ?? null;

            if (!$aiResponse) {
                throw new \Exception('No response generated from AI');
            }

            $this->view->layout('admin');
            $this->view('admin/assistant/sandbox-result', [
                'aiResponse' => $aiResponse,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'customPrompt' => $customPrompt,
                'transactionCount' => count($transactions),
                'transactions' => $transactions,
                'breadcrumb' => [
                    ['label' => 'Dashboard', 'url' => url('admin')],
                    ['label' => 'AI Assistant', 'url' => url('admin/assistant')],
                    ['label' => 'AI Sandbox', 'url' => url('admin/assistant/sandbox')],
                    ['label' => 'Result']
                ]
            ]);
        } catch (\Exception $e) {
            flash('error', 'Failed to generate response: ' . $e->getMessage());
            $this->redirect('/admin/assistant/sandbox');
        }
    }

    private function buildSandboxPrompt(array $transactions, string $customPrompt, string $startDate, string $endDate): string
    {
        $prompt = "# Custom Analysis Request\n\n";
        $prompt .= "**Analysis Period:** {$startDate} to {$endDate}\n";
        $prompt .= "**Total Transactions:** " . count($transactions) . "\n\n";
        $prompt .= "## User Request\n";
        $prompt .= $customPrompt . "\n\n";
        $prompt .= "## Transaction Data\n\n";
        $prompt .= "| Date | Type | Category | Product | Amount | Notes |\n";
        $prompt .= "|------|------|----------|---------|--------|-------|\n";

        foreach ($transactions as $transaction) {
            $date = is_array($transaction) ? $transaction['date'] : $transaction->date;
            $type = is_array($transaction) ? ($transaction['type'] ?? 'N/A') : ($transaction->type ?? 'N/A');
            $categoryId = is_array($transaction) ? ($transaction['category_id'] ?? null) : ($transaction->category_id ?? null);
            $productId = is_array($transaction) ? ($transaction['product_id'] ?? null) : ($transaction->product_id ?? null);
            $amount = is_array($transaction) ? ($transaction['amount'] ?? 0) : ($transaction->amount ?? 0);
            $notes = is_array($transaction) ? ($transaction['notes'] ?? '') : ($transaction->notes ?? '');

            $categoryName = 'N/A';
            if ($categoryId) {
                $category = Category::find($categoryId);
                if ($category) {
                    $categoryName = is_array($category) ? $category['name'] : $category->name;
                }
            }

            $productName = 'N/A';
            if ($productId) {
                $product = Product::find($productId);
                if ($product) {
                    $productName = is_array($product) ? $product['name'] : $product->name;
                }
            }

            $prompt .= "| {$date} | {$type} | {$categoryName} | {$productName} | \${$amount} | {$notes} |\n";
        }

        $prompt .= "\n## Instructions\n";
        $prompt .= "Based on the transaction data above, please respond to the user's request. Provide clear, detailed insights with specific data points when relevant. Use markdown formatting for better readability.\n";

        return $prompt;
    }
}
