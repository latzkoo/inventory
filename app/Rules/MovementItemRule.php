<?php

namespace App\Rules;

use App\Model\Movement;
use App\Model\Stock;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class MovementItemRule implements Rule
{

    private $request;
    private $movementID;
    private $movement;
    private $stock;
    private $stockError = [];
    private $isUpdate;

    /**
     * Create a new rule instance.
     * @param Request $request
     * @param int|null $movementID
     * @param bool $isUpdate
     */
    public function __construct(Request $request, int $movementID = null)
    {
        $this->movement = new Movement();
        $this->stock = new Stock();
        $this->request = $request;
        $this->movementID = $movementID;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($this->request->post("cikkID") as $key => $cikkID) {
            $currentStock = $this->stock->getStock($cikkID, $this->request->post("raktarID"));

            if ($this->movementID) {
                $movementItems = $this->movement->getItems($this->movementID);
                $inStock = $currentStock + $this->getMovementStock($movementItems, $cikkID);
            }
            else {
                $inStock = $currentStock;
            }

            if ($inStock < $this->request->post("mennyiseg")[$key]) {
                $this->stockError[$cikkID] = $currentStock;
            }
        }

        if (empty($this->stockError))
            return true;

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Bizonyos termékekből nincs elegendő mennyiség készleten!';
    }

    private function getMovementStock(array $movementItems, int $cikkID)
    {
        foreach ($movementItems as $cikk) {
            if ($cikk->cikkID == $cikkID)
                return $cikk->mennyiseg;
        }

        return null;
    }

}
