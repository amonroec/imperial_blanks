<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;

class InventoryController extends Controller
{

    public function sendInventory(Request $request) {
        $data = $request->all();
        $r = Inventory::truncate();
        foreach($data as $out) {
            $res = new Inventory();
            $res->style = $out['NWSTY'];
            $res->color_code = $out['NWCLR'];
            $res->color = $out['NWCDSC'];
            $res->sequence = $out['NWSEQ'];
            $res->quantity = $out['NWAVL'];
            $res->size = $out['NWSIZE'];
            $res->save();
        }
        return json_encode($data);
    }

    public function getInventory(Request $request) {
    	$user = $request->user;
        $colors = $request->colors;
        $styles = $request->styles;

    	// $res = Inventory::select()
    	// 				->where('customer_number', $user['customer_number'])
    	// 				->where('customer_number', '<>', '')
    	// 				->orderBy('customer_style', 'ASC')
    	// 				->offset($request->offset)
    	// 				->limit($request->limit)
    	// 				->get();

        if (count($styles) > 0 && count($colors) > 0) {
            $res = Inventory::select()
                        ->whereIn('color_code', $colors)
                        ->whereIn('style', $styles)
                        ->offset($request->offset)
                        ->limit($request->limit)
                        ->get();
        } else if (count($styles) > 0 && count($colors) < 1) {
            $res = Inventory::select()
                        ->whereIn('style', $styles)
                        ->offset($request->offset)
                        ->limit($request->limit)
                        ->get();
        } else if (count($styles) < 1 && count($colors) > 0) {
            $res = Inventory::select()
                        ->whereIn('color_code', $colors)
                        ->offset($request->offset)
                        ->limit($request->limit)
                        ->get();
        } else {
            $res = Inventory::select()
                        ->orderBy('style', 'ASC')
                        ->offset($request->offset)
                        ->limit($request->limit)
                        ->get();
        }
    	// $res = Inventory::all();

    	return $res;
    }

    public function searchSku(Request $request) {
        $search = $request->search;
        $user = $request->user;

        $res = Inventory::select()
                        ->where('customer_number', $user['customer_number'])
                        ->where('customer_style', $search)
                        ->get();
        return $res;
    }

    public function getFilters(Request $request) {
        $user = $request->user;

        $res = Inventory::select('color_code')
                        ->groupBy('color_code')
                        ->orderBy('color_code', 'ASC')
                        ->get();

        $colors = [];
        foreach($res as $out) {
            array_push($colors, $out['color_code']);
        }

        $res2 = Inventory::select('style')
                        ->groupBy('style')
                        ->orderBy('style', 'ASC')
                        ->get();

        $styles = [];
        foreach($res2 as $out) {
            array_push($styles, $out['style']);
        }
        return compact('colors', 'styles');
    }

    public function getFilterData(Request $request) {
        $user = $request->user;
        $styles = $request->style;
        $colors = $request->color;

        if (count($styles) > 0 && count($colors) > 0) {
            $res = Inventory::select()
                        ->where('customer_number', $user['customer_number'])
                        ->whereIn('customer_color', $colors)
                        ->whereIn('booking_style', $styles)
                        ->get();
        } else if (count($styles) > 0 && count($colors) < 1) {
            $res = Inventory::select()
                        ->where('customer_number', $user['customer_number'])
                        ->whereIn('booking_style', $styles)
                        ->get();
        } else if (count($styles) < 1 && count($colors) > 0) {
            $res = Inventory::select()
                        ->where('customer_number', $user['customer_number'])
                        ->whereIn('customer_color', $colors)
                        ->get();
        }

        return $res;
    }

    public function testApi(Request $request) {
        
        // $url = 'https://imperial.secure-decoration.com/api/json/manage_inventory/update';
        $url='https://imperial.secure-decoration.com/api/json/manage_inventory/find?';
        // $url='https://imperial.secure-decoration.com/api/json/manage_inventory/find?conditions%5B1%5D%5Bfield%5D=1&conditions%5B1%5D%5Bcondition%5D=1&conditions%5B1%5D%5Bdate1%5D=2020-02-10T20%3A13%3A37&conditions%5B1%5D%5Bdate2%5D=&conditions%5B1%5D%5Bnumber1%5D=&conditions%5B1%5D%5Bnumber2%5D=&conditions%5B1%5D%5Bstring%5D=X210P&limit=10&offset=0&sortby=1&username=acoleman&password=Bourbon%21929&commit=Search';
        $body = (object)[];
        $style = $request->style;
        // $body->dn_sku_id = 'X210P-JXX';
        // $body->inv_on = true;
        // $body->inv_lvl = 25;
        // $body->inv_warn = 5;
        // $body->inv_reorder_to = 1;
        $body->username = 'acoleman';
        $body->string = 'X210P';
        $body->field = 1;
        $body->limit = 10;
        $body->condition = 1;
        $body->password = 'Bourbon!929';

        $cond[1]['field'] = 1;
        $cond[1]['limit'] = 10;
        $cond[1]['offset'] = 0;
        $cond[1]['condition'] = 1;
        $cond[1]['string'] = $style;

        // $cond[2]['field'] = 1;
        // $cond[2]['limit'] = 10;
        // $cond[2]['offset'] = 0;
        // $cond[2]['condition'] = 1;
        // $cond[2]['string'] = 'X210B';

        // $arr = ['field' => 1, 'limit' => 10, 'offset' => 0, 'condition' => 1, 'string' => 'X210P'];
        // $arr2 = ['field' => 1, 'limit' => 10, 'offset' => 0, 'condition' => 1, 'string' => 'X210B'];
        // $cond[0] = $arr;
        // $cond[1] = $arr2;

        // $cond[1][1]['string'] = 'X210P';
        // $cond[1][1]['offset'] = 0;
        // $cond[1][1]['field'] = 1;

        // $cond[2][1]['string'] = 'X210B';
        // $cond[2][1]['offset'] = 0;
        // $cond[2][1]['field'] = 1;

        // $content = http_build_query(
        //     array(
        //         'username' => 'acoleman',
        //         'password' => 'Bourbon!929',
        //         // 'dn_sku_id' => '4921453_270361503',
        //         'dn_sku_id' => '205785403_271704763',
        //         'inv_on' => true,
        //         'inv_lvl' => 240,
        //         'inv_reorder_to' => 200,
        //         'inv_warn' => 25
        //     )
        // );

        $content = http_build_query(
            array(
                'username' => 'acoleman',
                'password' => 'Bourbon!929',
                // 'dn_sku_id' => '4921453_270361503',
                'conditions' => $cond
            )
        );
        // $body->commit = 'Update';

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-Type: application/json",
                'method'  => 'GET',
                // 'content' => $content
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url . $content, false, $context);

        return compact('result', 'cond', 'style');
    }
}
