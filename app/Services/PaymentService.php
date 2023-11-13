<?php
namespace App\Services;

use App\Models\Reservation;
use Exception;

class PaymentService {
    private $reservation;
    private $request;

    public function __construct(Reservation $reservation, array $request) {
        $this->reservation = $reservation;
        $this->request     = $request;
    }

    public function reservationPayment() {
        if ($this->request['payment_method'] == 'wallet') {
            $this->payReservationByWallet();
        } else {
            $this->payReservationBySms();
        }
    }

    public function payReservationByWallet(): void {
        $user        = auth()->user();
        $transaction = new TransactionService();
        if ($user->wallet_balance < $this->request['final_total']) {
            throw new Exception(__('apis.no_enough_balance_in_wallet'));
        }

        $transaction->walletPaySuccess($this->reservation);

        $this->reservation->update([
            'payment_status' => 'paid',
        ]);

    }

    public function payReservationBySms() {
        $this->request['payment_status'] = 'paid';
        return $this->request;
    }
}
