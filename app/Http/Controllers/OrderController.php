<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return $this->getResponse200($orders);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'amount' => 'required',
            'store_id' => 'required',
            'product_id' => 'required'
        ]);
        if (!$validator->fails()) {
            DB::beginTransaction();
            try {
                $order = new Order();
                $order->status = $request->status;
                $order->amount = $request->amount;
                $order->product_id = $request->product_id;
                $order->store_id = $request->store_id;
                $order->save();
                DB::commit();
                return $this->getResponse201('order', 'created', $order);
            } catch (Exception $e) {
                DB::rollBack();
                return $this->getResponse500([$e->getMessage()]);
            }
        } else {
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'amount' => 'required',
            'store_id' => 'required',
            'product_id' => 'required'
        ]);
        if (!$validator->fails()) {
            $order = Order::find($id);
            DB::beginTransaction();
            try {
                $order->status = $request->status;
                $order->amount = $request->amount;
                $order->product_id = $request->product["id"];
                $order->store_id = $request->store["id"];
                $order->save();
                DB::commit();
                return $this->getResponse201('order', 'updated', $order);
            } catch (Exception $e) {
                DB::rollBack();
                return $this->getResponse500([$e->getMessage()]);
            }
        }
    }

    public function show($id)
    {
        $order = Order::find($id);
        DB::beginTransaction();
        if ($order != null) {
            return $this->getResponse200($order);
        } else {
            return $this->getResponse404();
        }
    }

    public function destroy($id)
    {
        $order = Order::find($id);
        if ($order != null) {
            $order->delete();
            return $this->getResponse200($order);
        } else {
            return $this->getResponse404();
        }
    }
}