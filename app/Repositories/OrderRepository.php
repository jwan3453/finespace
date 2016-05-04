<?php
namespace App\Repositories;
use App\Models\Order;
    use App\Models\OrderItem;
    use App\Models\Product;
    use App\Models\Image;
    use App\Models\ShoppingCart;
    use App\User;
    use App\Models\Store;

    use Illuminate\Support\Collection;

    use Auth;

class OrderRepository implements  OrderRepositoryInterface{

    public function selectAll($paginate = 0)
        {
            if($paginate!=0)
                return Order::paginate($paginate);
            else

            return Order::all();
        }

        public function find($id)
        {
            return Order::find($id);
        }



        public function findBy($query){

            $obj = null;
            $count = 0;

            foreach($query as $q)
            {


                if($count == 0)
                {
                 $obj = Order::where($q['key'],$q['compare'],$q['value']);

                }
                else
                {
                    $obj->where($q['key'],$q['compare'],$q['value']);

                }
                $count++;
            }

           return $obj;
        }

        public function updatePaymentMethod($request)
        {
            $where['order_no']= $request->input('orderNo');
            $update['payment_id'] = $request->input('paymentMethod');
            $query['where'] = $where;
            $query['update'] = $update;
            return Order::where($query['where'])->update($query['update']);
        }

        public function cancelOrder($orderNo)
        {
            return Order::where('order_no',$orderNo)->update(['status'=> 0] );
        }
    //    public function save($obj)
    //    {
    //
    //        $newOrder = new Order();
    //        $newOrder->order_no = $obj['order_no'];
    //        $newOrder->user_id = $obj['user_id'];
    //        $newOrder->address_id = $obj['address_id'];
    //        $newOrder->recipient_id = $obj['recipient_id'];
    //        $newOrder->shipping_id = $obj['shipping_id'];
    //        $newOrder->payment_id = $obj['payment_id'];
    //        $newOrder->delivery_time = $obj['delivery_time'];
    //        $newOrder->total_amount = $obj['total_amount'];
    //        $newOrder->shipping_fee = $obj['shipping_fee'];
    //        $newOrder->status = $obj['status'];
    //        $newOrder->shipping_status = $obj['shipping_status'];
    //        $newOrder->pay_status = $obj['pay_status'];
    //        $newOrder->save();
    //        return $newOrder;
    //
    //    }


        public function getOrderDetail($orderNo)
        {

             $order = Order::where('order_no',$orderNo)->first();

            $orderItemArray = array();

            if($order!=null)
            {

                $orderItems =  $order->orderItems()->get();//OrderItem::where('order_id',$orderDetail['order']->id)->get();//->findBy(['order_id'=>$orderDetail['order']->id]);



                //逻辑跟购物车获取cart item array 一样
                $orderItemArray = (new ShoppingCartRepository())->setCartItemArray($orderItems,$orderItemArray);

            }
            else
            {
                return null;
            }
            $orderDetail['order'] = $order;
            $orderDetail['orderItems'] = $orderItemArray;


            return $orderDetail;
        }

        public function generateOrder( $request)
        {

            $payMethod =  $request->input('payMethod');
            $deliveryAddr = $request->input('deliveryAddr');
            $totalPrice = 0.0;



                $cartItems = ShoppingCart::where('user_id',Auth::user()->id)->get();
                $newOrderArray = [
                    'order_no' => 'E' . time() . '' . uniqid(),
                    'user_id' => Auth::User()->id,
                    'address_id' => $deliveryAddr,
                    'recipient_id' => 1,
                    'shipping_id' => 1,
                    'payment_id' => $payMethod,
                    'delivery_time' => '2016-03-16:12.12.12',
                    'total_amount' => $totalPrice,
                    'shipping_fee' => 0,
                    'status' => 0,
                    'shipping_status' => 0,
                    'pay_status' => 0
                ];
                //保存订单
                $newOrder = Order::create($newOrderArray);


                foreach ($cartItems as $key => $cartValue) {
                    $cartValue->product =Product::find($cartValue->product_id);//->find($cartValue->product_id);
                    if ($cartValue->product != null) {
                        $totalPrice += $cartValue->product->price * $cartValue->count;
                    }

                    $newOrderItem = [
                        'order_id' => $newOrder->id,
                        'product_id' => $cartValue->product->id,
                        'parent_product_id' => $cartValue->parent_product_id,
                        'count' => $cartValue->count,
                        'product_detail' => json_encode($cartValue->product),
                        'order_dateTime' =>$cartValue->order_dateTime,
                        'selected_store' => $cartValue->selected_store
                    ];

                    OrderItem::create($newOrderItem);
                }

                $newOrder->total_amount = $totalPrice;
                $newOrder->save();
                return $newOrder;

        }


        public function getAllOrder($paymentStatus)
        {


                $orders = null;
                if($paymentStatus != -1)
                {
                    $orders =   Order::where('user_id',Auth::user()->id)->where('pay_status',$paymentStatus)->get();
                }
                else{
                    $orders = Order::where('user_id',Auth::user()->id)->get();
                }




                foreach($orders as $order)
                {
                    $orderItems =  OrderItem::where('order_id',$order->id);

                    foreach($orderItems as $orderItem)
                    {
                        $orderItem->product = Product::where('id',$orderItem->product_id)->first();
                    }

                    $order->orderItems = $orderItems;
                }

                return $orders;


        }

        public function manageOrder($seachData,$paginate = 0)
        {
            if ($paginate != 0) {
                if ($seachData['from'] != '' && $seachData['to'] != '') {
                    $orderDetail = Order::where('order_no' , 'like' , "%".$seachData['seachData']."%")->whereBetween('created_at',array($seachData['from'],$seachData['to']))->paginate($paginate);
                }else{
                    $orderDetail = Order::where('order_no' , 'like' , "%".$seachData['seachData']."%")->paginate($paginate);
                }
                
            }else{
                if ($seachData['from'] != '' && $seachData['to'] != '') {
                    $orderDetail = Order::where('order_no' , 'like' , "%".$seachData['seachData']."%")->whereBetween('created_at',array($seachData['from'],$seachData['to']))->get();
                }else{
                    $orderDetail = Order::where('order_no' , 'like' , "%".$seachData['seachData']."%")->get();
                }
                
            }
            
            return $orderDetail;
            
        }

        public function TodayOrderCount()
        {
            $date = date('Y-m-d');
            // $date = '2016-03-17';
            $count = Order::where('created_at' , 'like' , $date."%")->select('id')->count();
           
            return $count;
        }

        public function SevenDayOrder()
        {
            $timeNow = time();
            
            $SevenDayOrder = array();
            for ($i=6; $i > 0; $i--) { 
                $time = $timeNow;
                $time = $time - (3600 * 24 * $i);

                $today = date('Y-m-d' , $time);

                $count = Order::where('created_at' , 'like' , $today."%")->select('id')->count();
                
                $SevenDayOrder[$i]['count'] = $count;
                $SevenDayOrder[$i]['date'] = $today;
            }
            return $SevenDayOrder;
            // dd($SevenDayOrder);
        }

        public function TodayIncomeSum()
        {
            $date = date('Y-m-d');
            // $date = '2016-03-17';
            $sum = Order::where('created_at' , 'like' , $date."%")->where('pay_status' , 1)->select('id')->sum('total_amount');
            // dd($sum);
            return $sum;
        }

        public function SevenDayIncome($value='')
        {
            $timeNow = time();
            
            $SevenDayIncome = array();
            for ($i=6; $i > 0; $i--) { 
                $time = $timeNow;
                $time = $time - (3600 * 24 * $i);

                $today = date('Y-m-d' , $time);

                $sum = Order::where('created_at' , 'like' , $today."%")->where('pay_status' , 1)->select('id')->sum('total_amount');
                
                $SevenDayIncome[$i]['sum'] = $sum;
                $SevenDayIncome[$i]['date'] = $today;
            }
            return $SevenDayIncome;
        }


        public function StockingOrder()
        {
            $date = date('Y-m-d');
            //获取日期大于等于今天的orderitem、并且以order_dateTime排序
            $orderitems = OrderItem::where('order_dateTime' , '>=' , $date)->orderBy('order_dateTime','asc')->get();
            //对结果以order_id进行groubu以实现间接去除重复
            $item = $orderitems->groupBy('order_id');
            
            $order = new Collection();
           
            foreach ($item as $key => $v) {
                //获取订单详情
                $orderInfo = Order::where('id',$key)->where('pay_status',1)->first();

                if ($orderInfo != '') {
                    //返回的订单详情信息中插入order_dateTime
                    $orderInfo->order_dateTime = $v[0]->order_dateTime;
                   
                    $order->push($orderInfo);
                }
              
            }
            return $order;
            
        }

        public function seachStatementData($order_no)
        {
            $orderDetail = Order::where('order_no' , $order_no)->first();

            if ($orderDetail) {
                //获取order_items
                $orderDetail->orderItems = OrderItem::where('order_id',$orderDetail->id)->select('id','product_id','product_detail','statement_status','selected_store','order_dateTime')->get();


                foreach ($orderDetail->orderItems as $v) {

                    $product = Product::where('id',$v->product_id)->select('type')->first();
               
                    $v->type= $product->type;

                    if ($v->selected_store != 0) {
                        $v->Store_name = Store::where('id',$v->selected_store)->select('name')->first()->name;
                    }else{
                        $v->Store_name = "未知门店";
                    }

                    switch ($v->statement_status) {
                        case '0':
                            $v->statement_name = "未消费";
                            break;
                        case '1':
                            $v->statement_name = "已消费";
                            break;
                        default:
                            $v->statement_name = "未知状态";
                            break;
                    }

                    switch ($v->type) {
                        case '1':
                            $v->type_name = "取餐";
                            break;
                        case '2':
                            $v->type_name = "就餐";
                            break;
                        default:
                            $v->type_name = "未知";
                            break;
                    }
                }

                //获取用户信息
                $orderDetail->userData = User::where('id',$orderDetail->user_id)->select('name','mobile')->first();


                switch ($orderDetail->payment_id) {
                    case '0':
                        $orderDetail->payment_name = "未知";
                        break;

                    case '1':
                        $orderDetail->payment_name = "微信";
                        break;

                    case '2':
                        $orderDetail->payment_name = "支付宝";
                        break;

                    case '3':
                        $orderDetail->payment_name = "余额支付";
                        break;

                    case '4':
                        $orderDetail->payment_name = "上门自提";
                        break;
                    
                }

                switch ($orderDetail->pay_status) {
                    case '0':
                        $orderDetail->pay_name = "未支付";
                        break;

                    case '1':
                        $orderDetail->pay_name = "已支付";
                        break;
                    
                    default:
                        $orderDetail->pay_name = "未知";
                        break;
                }

                switch ($orderDetail->status) {
                    case '0':
                        $orderDetail->status_name = "已取消";
                        break;

                    case '1':
                        $orderDetail->status_name = "已确认";
                        break;
                    
                    default:
                        $orderDetail->status_name = "未知状态";
                        break;
                }


            }else{
                $orderDetail = false;
            }
            
            return $orderDetail;

        }

        public function check_Real_One($orderItems_id)
        {
            $orderItems = OrderItem::where('id',$orderItems_id)->select('statement_status')->first();

            if ($orderItems) {
                if ($orderItems->statement_status == 1) {
                    return 2;
                }else{
                    OrderItem::where('id',$orderItems_id)->update(['statement_status'=>1]);
                    return 1;
                }
            }else{
                return 3;
            }


        }

        public function check_All_Real($order_id = 0)
        {
            if ($order_id != 0) {

                $check = OrderItem::where('order_id',$order_id)->update(['statement_status'=>1]);

                if ($check) {
                    return 1;
                }else{
                    return 2;
                }
            }else{
                return 3;
            }
        }


    }


    ?>