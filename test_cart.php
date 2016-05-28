<?php
//include(__DIR__ . '/init.inc.php');

//Pix_Table::$_log_groups = array();

function run()
{
    $promotion_A  = array("name" => "promotionA","pair_num"=>3,"discount"=>0.8);
    $promotion_B  = array("name" => "promotionB","pair_num"=>2,"discount"=>0.7);
    $promotion_items_A = array("a", "b", "c");
    $promotion_items_B = array("a", "c", "d");

    $cart = array(
        "a" => 5,
        "b" => 5,
        "c" => 5,
        //"d" => 1,
        //"e" => 2,
    );

    // $cart_items_in_A = getItemInPromotion($cart, $promotion_items_A);
    // $cart_items_in_B = getItemInPromotion($cart, $promotion_items_B);

    // $pairs_A = getPromotionPairs($cart_items_in_A, $promotion_A);
    // $pairs_B = getPromotionPairs($cart_items_in_B, $promotion_B);

    // $all_pairs = array_merge($pairs_A, $pairs_B);

    //not finish yet
    $lowest_cart = getLowestPrice($cart);
    print_r($lowest_cart);
    exit;
}

function getPromotionPairs($items = array(), $promotion = array()) {
    if (empty($items) || !is_array($items)) {
        return array();
    }

    foreach ($items as $item_id => $amount) {
        for ($i = 0; $i < $amount; $i++) { 
            $all_items[] = $item_id;
        }
    }

    $pair_strings = getGroupStrings($all_items, $promotion['pair_num']);
    $promotionPairs = array();
    foreach ($pair_strings as $single_pair_string) {
        $single_pair = array();
        $single_pair['promotion_name'] = $promotion['name'];
        $item_ids = explode(",", $single_pair_string);
        $single_pair['item_ids'] = $item_ids;
        $total_price = 0;
        foreach ($item_ids as $id) {
            $total_price += getPrice($id);
        }

        $single_pair['price'] = (int)($total_price * $promotion['discount']);
        $single_pair['origin_price'] = $total_price;

        $promotionPairs[] = $single_pair;
    }

    return $promotionPairs;
}

function getGroupStrings($all_items, $num = 1)
{
    $sub_num = $num - 1;
    if (0 == $sub_num) {
        return array_unique($all_items);
    }
    if (count($all_items) == $num) {
        return array(implode(',', $all_items));
    }
    $groups = array();
    while ($item = array_shift($all_items)) {
        $sub_group_strings = getGroupStrings($all_items, $sub_num);
        while ($sub_group_string = array_shift($sub_group_strings)) {
            $group_string = "{$item},{$sub_group_string}";
            $groups[$group_string] = $group_string;
        }
    }
    return array_values($groups);
}

function getPrice($id) {
    $products = array(
        "a" => 100,
        "b" => 180,
        "c" => 230,
        "d" => 199,
        "e" => 205,
    );

    if (array_key_exists($id, $products)){
        return $products[$id];
    } else {
        return 0;
    }
}

function getItemInPromotion($item_ids, $promotion_item_ids) {
    $result = array();
    foreach ($item_ids as $id => $amount) {
        if (in_array($id, $promotion_item_ids)) {
            $result[$id] = $amount;
        }
    }
    return $result;
}

function getLowestPrice($cart = array()) {
    if (empty($cart)) {
        return $cart;
    }

    $cart_pairs = getCartPair($cart);
    $cart_pairs = array_unique($cart_pairs);
    $cart_pairs = array_values($cart_pairs);

    print_r($cart_pairs);
    exit;
    /*end here*/

    //TODO: get each pair's price and find the lowest one
    foreach ($cart_pairs as $single_cart_pair) {
        $total_price = 0;
        foreach ($single_cart_pair as $item_or_promotion_pair) {

        }
    }

    return $lowest_price;
}

function getCartPair($cart) {
    $all_cart_pairs = array();
    if (empty($cart)) {
        return array();
    }
    $promotion_A  = array("name" => "promotionA","pair_num"=>3,"discount"=>0.8);
    $promotion_B  = array("name" => "promotionB","pair_num"=>2,"discount"=>0.7);
    $promotion_items_A = array("a", "b", "c");
    $promotion_items_B = array("a", "c", "d");

    $cart_items_in_A = getItemInPromotion($cart, $promotion_items_A);
    $cart_items_in_B = getItemInPromotion($cart, $promotion_items_B);

    $pairs_A = getPromotionPairs($cart_items_in_A, $promotion_A);
    $pairs_B = getPromotionPairs($cart_items_in_B, $promotion_B);

    $all_pairs = array_merge($pairs_A, $pairs_B);
    foreach ($all_pairs as $single_pair) {
        $flag = true;
        $new_cart = $cart;
        foreach ($single_pair['item_ids'] as $target_id) {
            if (!array_key_exists($target_id, $new_cart)) {
                $flag = false;
                break;
            }

            $new_cart[$target_id] --;
            if (0 == $new_cart[$target_id]) {
                unset($new_cart[$target_id]);
            }
        }

        if ($flag == false) {
            continue;
        }

        if (empty($new_cart)) {
            return array(implode(":", $single_pair['item_ids']));
        }

        $rest_pairs = getCartPair($new_cart);

        if (empty($rest_pairs)) {
            $cart_pair = implode(":", $single_pair['item_ids']);

            foreach ($new_cart as $id => $amount) { 
                $cart_pair .= ", {$id}";
            }

            $all_cart_pairs[$cart_pair] = $cart_pair;
        } else {
            foreach ($rest_pairs as $cart_pair) {
                $cart_pair_combo = implode(":", $single_pair['item_ids']).", ".$cart_pair;
                $all_cart_pairs[$cart_pair_combo] = $cart_pair_combo;
            }
        }
    }

    return $all_cart_pairs;
}

try {
    run();
} catch (Exception $e) {
    LogLib::logException($e);
}

