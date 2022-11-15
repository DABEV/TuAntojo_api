<?php

namespace App\Http\Controllers;

use App\Models\OrderProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderProductController extends Controller
{
    public function index()
    {
        $ordersProducts = OrderProduct::all();
        return $this->getResponse200($ordersProducts);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'product_id' => 'required',
            'order_id' => 'required'
        ]);
        if (!$validator->fails()) {
            DB::beginTransaction();
            try {
                $orderProduct = new OrderProduct();
                $orderProduct->amount = $request->amount;
                $orderProduct->product_id = $request->product_id;
                $orderProduct->order_id = $request->order_id;
                $orderProduct->save();
                DB::commit();
                return $this->getResponse201('orderProduct', 'created', $orderProduct);
            } catch (Exception $e) {
                DB::rollBack();
                return $this->getResponse500([$e->getMessage()]);
            }
        } else {
            return $this->getResponse500([$validator->errors()]);
        }
    }

    public function show($id)
    {
        $orderProduct = OrderProduct::find($id);
        if ($orderProduct != null) {
            return $this->getResponse200($orderProduct);
        } else {
            return $this->getResponse404();
        }
    }
    public function destroy($id)
    {
        $orderProduct = OrderProduct::find($id);
        if ($orderProduct != null) {
            $orderProduct->delete();
            return $this->getResponse200($orderProduct);
        } else {
            return $this->getResponse404();
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'product_id' => 'required',
            'order_id' => 'required'
        ]);
        if (!$validator->fails()) {
            $orderProduct = OrderProduct::find($id);
            DB::beginTransaction();
            try {
                $orderProduct->amount = $request->amount;
                $orderProduct->product_id = $request->product_id;
                $orderProduct->order_id = $request->order_id;
                $orderProduct->save();
                DB::commit();
                return $this->getResponse201('order', 'updated', $orderProduct);
            } catch (Exception $e) {
                DB::rollBack();
                return $this->getResponse201('orderProduct', 'updated', $orderProduct);
            }
        } else {
            return $this->getResponse500([$validator->errors()]);
        }
    }
}
