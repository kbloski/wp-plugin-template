<?php 

namespace Finance\Inc\Application\Rest\Transactions\Callbacks;

use Finance\Inc\Application\Services\BudgetUsersService;
use Finance\Inc\Core\Logger\Logger;
use Finance\Inc\Domain\DTOs\BudgetDto;
use Finance\Inc\Infrastructure\Repositories\TransactionsRepository;
use Throwable;
use WP_Error;
use WP_REST_Response;

class GetAllBudgetTransactionsCallback 
{
    protected function __construct() {}

    public static function handle(\WP_REST_Request $request): WP_REST_Response|WP_Error
    {
        try 
        {   
            $budgetId = (int) $request->get_param('budgetId');

            $transactions = TransactionsRepository::getInstance()->getByBudgetId($budgetId);

            return new \WP_REST_Response([
                'transactions' => $transactions
            ], 200);
        } catch (\Throwable $e) 
        {
            Logger::error($e);
            return new \WP_Error(
                'internal_error',
                'An unexpected error occurred',
                ['status' => 500]
            );
        }
    }
}
