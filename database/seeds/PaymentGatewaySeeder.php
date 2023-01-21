<?php

namespace Database\Seeders;

use App\Models\Backend\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 'Paypal', '{"CLIENT_ID":"ARx1Wy-Qy0MmXq7q5CQ7zvDXtqzAWyUBApkTtloskE8MIYUp6PoI56OS7RIud_yV1kKLOJFn8G_1YGjq","CLIENT_SECRET":"EPtYFQNvUYEq1w9Ha5sM-d2bmmi5auB0Am1o8Gs7BCmWg2Pb141qZQiKJF1eZM2rg6_C_VIfbLnwiQjb","MODE":"sandbox"}', 1, '2022-03-01 06:00:00', '2022-03-13 05:59:47'],
            [2, 'Stripe', '{"KEY":"pk_test_51H6KMFIfOCXG9q7w4xViyhGFg8cmL6FpSIBVStdHbbZBpq7nV8tlvPqGSuio6RbSNktAFYdeWjnP15oP4vPPot2G00XOERo6y4","SECRET":"sk_test_51H6KMFIfOCXG9q7wPbv8qfbfFOHsvXeWyhQ5WXy7uDhuLoQAvFDpzpbDYTKyDWqGIOhqyfZ9sskvMukJxGUwDLPv00B3DHS986"}', 1, '2022-03-01 06:00:07', '2022-03-13 05:59:51'],
            [3, 'Razorpay', '{"KEY_ID":"rzp_test_jHtbUVoaZyQma0","KEY_SECRET":"fEudhWW24uwP414AOsUDBtm0"}', 1, '2022-04-05 12:00:07', '2022-04-05 12:00:07']
        ];

        foreach ($data as $d){
            PaymentGateway::query()->create([
                'id' => $d[0],
                'name' => $d[1],
                'configuration' => $d[2],
                'status' => $d[3],
                'created_at' => $d[4],
                'updated_at' => $d[5],
            ]);
        }
    }
}
