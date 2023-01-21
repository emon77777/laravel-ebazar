<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [1, 'super-admin', 'admin', '2021-07-27 08:52:24',  NULL],
            [4, 'admin', 'admin', '2021-08-08 12:45:31',  '2021-09-06 11:38:13' ],
            [5, 'Manager', 'admin', '2021-08-08 13:02:21', '2021-09-06 11:40:16' ],
            // [7, 'Seller', 'seller', '2021-09-10 07:52:57', '2021-09-10 07:53:18' ],
        ];

        $permissions = [
            // Dashboard policy
            [ '1', 'browse_dashboard', 'admin', 'dashboard'],
            [ '2', 'browse_order_dashboard', 'admin', 'dashboard'],
            [ '3', 'browse_statistic_dashboard', 'admin', 'dashboard'],
            [ '4', 'browse_customer_dashboard', 'admin', 'dashboard'],
            [ '88', 'browse_best_selling_dashboard', 'admin', 'dashboard'],
            [ '89', 'browse_best_customer_dashboard', 'admin', 'dashboard'],
            [ '90', 'browse_count_box_dashboard', 'admin', 'dashboard'],
            // [ '5', 'browse_dashboard', 'seller', 'dashboard'],

            // Role policy
            [ '6', 'browse_roles', 'admin', 'role'],
            [ '92', 'list_roles', 'admin', 'role'],
            [ '7', 'create_roles', 'admin', 'role'],
            [ '8', 'edit_roles', 'admin', 'role'],
            [ '9', 'delete_roles', 'admin', 'role'],

            // User policy
            [ '10', 'browse_users', 'admin', 'user'],
            [ '91', 'list_users', 'admin', 'user'],
            [ '11', 'create_users', 'admin', 'user'],
            [ '12', 'edit_users', 'admin', 'user'],
            [ '13', 'delete_users', 'admin', 'user'],

            // Order policy
            [ '14', 'browse_order_management', 'admin', 'order'],
            [ '15', 'browse_pending_orders', 'admin', 'order'],
            [ '16', 'browse_orders', 'admin', 'order'],
            [ '17', 'browse_confimed_orders', 'admin', 'order'],
            [ '18', 'browse_processing_orders', 'admin', 'order'],
            [ '19', 'browse_picked_order', 'admin', 'order'],
            [ '20', 'browse_shipped_orders', 'admin', 'order'],
            [ '21', 'browse_delivered_orders', 'admin', 'order'],
            [ '22', 'browse_cancelled_orders', 'admin', 'order'],
            [ '23', 'edit_orders', 'admin', 'order'],
            [ '24', 'delete_orders', 'admin', 'order'],
            // [ '25', 'browse_orders', 'seller', 'order'],
            // [ '26', 'browse_pending_orders', 'seller', 'order'],
            // [ '27', 'browse_confimed_orders', 'seller', 'order'],
            // [ '28', 'browse_processing_orders', 'seller', 'order'],
            // [ '29', 'browse_shipped_orders', 'seller', 'order'],
            // [ '30', 'browse_delivered_orders', 'seller', 'order'],
            // [ '31', 'browse_cancelled_orders', 'seller', 'order'],

            // Customer policy
            [ '32', 'browse_customer_management', 'admin', 'customer'],
            [ '33', 'browse_customers', 'admin', 'customer'],
            [ '34', 'browse_suspended_customers', 'admin', 'customer'],
            [ '94', 'browse_email_subscriber', 'admin', 'customer'],
            [ '95', 'active_customers', 'admin', 'customer'],
            [ '96', 'suspend_customers', 'admin', 'customer'],
            [ '35', 'create_customers', 'admin', 'customer'],
            [ '36', 'edit_customers', 'admin', 'customer'],
            [ '93', 'email_customers', 'admin', 'order'],
            [ '37', 'delete_customers', 'admin', 'customer'],
            // [ '38', 'browse_customers', 'seller', 'customer'],
            // [ '39', 'browse_order_management', 'seller', 'order'],
            // [ '40', 'browse_picked_order', 'seller', 'order'],

            // Product policy
            [ '41', 'browse_product_management', 'admin', 'product'],
            [ '42', 'browse_products', 'admin', 'product'],
            [ '43', 'create_products', 'admin', 'product'],
            [ '86', 'browse_promotion_management', 'admin', 'product'],
            [ '44', 'browse_promotional_products', 'admin', 'product'],
            [ '45', 'create_promotional_products', 'admin', 'product'],
            [ '101', 'edit_promotional_products', 'admin', 'product'],
            [ '103', 'delete_promotional_products', 'admin', 'product'],
            // [ '46', 'browse_product_review', 'admin', 'product'],
            // [ '47', 'create_product_review', 'admin', 'product'],
            // [ '48', 'edit_product_review', 'admin', 'product'],
            // [ '49', 'delete_product_review', 'admin', 'product'],
            [ '50', 'edit_products', 'admin', 'product'],
            [ '51', 'delete_products', 'admin', 'product'],
            // [ '52', 'browse_product_management', 'seller', 'product'],
            // [ '53', 'browse_products', 'seller', 'product'],
            // [ '54', 'create_products', 'seller', 'product'],
            // [ '87', 'browse_promotion_management', 'seller', 'product'],
            // [ '55', 'browse_promotional_products', 'seller', 'product'],
            // [ '56', 'create_promotional_products', 'seller', 'product'],
            // [ '57', 'browse_product_review', 'seller', 'product'],
            // [ '58', 'create_product_review', 'seller', 'product'],
            // [ '59', 'edit_product_review', 'seller', 'product'],
            // [ '60', 'delete_product_review', 'seller', 'product'],
            // [ '61', 'edit_products', 'seller', 'product'],
            // [ '62', 'delete_products', 'seller', 'product'],

            // Categoty Policy
            [ '63', 'browse_categories', 'admin', 'category'],
            [ '64', 'create_categories', 'admin', 'category'],
            [ '97', 'edit_categories', 'admin', 'category'],
            [ '98', 'delete_categories', 'admin', 'category'],
            // [ '65', 'browse_categories', 'seller', 'category'],
            // [ '66', 'create_categories', 'seller', 'category'],
            
            // Brand Policy
            [ '67', 'browse_brands', 'admin', 'brand'],
            [ '68', 'create_brands', 'admin', 'brand'],
            [ '99', 'edit_brands', 'admin', 'brand'],
            [ '102', 'delete_brands', 'admin', 'brand'],
            // [ '69', 'browse_brands', 'seller', 'brand'],
            // [ '70', 'create_brands', 'seller', 'brand'],

            // Seller Policy
            // [ '71', 'browse_sellers', 'admin', 'seller'],
            // [ '72', 'create_sellers', 'admin', 'seller'],
            // [ '73', 'edit_sellers', 'admin', 'seller'],
            // [ '74', 'delete_sellers', 'admin', 'seller'],
    
            // Content policy
            // [ '84', 'browse_content_management', 'admin', 'content'],
            // [ '85', 'browse_content_management', 'seller', 'content'],

            // Banner policy
            [ '84', 'browse_content_management', 'admin', 'banner'],
            [ '75', 'browse_banners', 'admin', 'banner'],
            [ '76', 'edit_banners', 'admin', 'banner'],
            [ '77', 'delete_banners', 'admin', 'banner'],
            [ '78', 'create_banners', 'admin', 'banner'],
            // [ '79', 'browse_banners', 'seller', 'banner'],
            // [ '80', 'create_banners', 'seller', 'banner'],
            // [ '81', 'edit_banners', 'seller', 'banner'],
            // [ '82', 'delete_banners', 'seller', 'banner'],

            // System policy
            [ '83', 'browse_system_config', 'admin', 'system'],
            
            // Setting policy
            [ '128', 'browse_website_setting', 'admin', 'setting'],
            [ '129', 'browse_header', 'admin', 'setting'],
            [ '130', 'browse_pages', 'admin', 'setting'],
            [ '131', 'browse_appearance', 'admin', 'setting'],
            [ '100', 'browse_announcements', 'admin', 'setting'],

            // FAQ Categoty Policy     -----------  Not needed now
            // [ '104', 'browse_faq_categories', 'admin', 'faq_category'],
            // [ '105', 'create_faq_categories', 'admin', 'faq_category'],
            // [ '106', 'edit_faq_categories', 'admin', 'faq_category'],
            // [ '107', 'delete_faq_categories', 'admin', 'faq_category'],
            // [ '108', 'browse_faq_categories', 'seller', 'faq_category'],
            // [ '109', 'create_faq_categories', 'seller', 'faq_category'],
            // [ '110', 'edit_faq_categories', 'seller', 'faq_category'],
            // [ '111', 'delete_faq_categories', 'seller', 'faq_category'],

            // FAQ Sub Categoty Policy     -----------  Not needed now
            // [ '112', 'browse_faq_sub_categories', 'admin', 'faq_sub_category'],
            // [ '113', 'create_faq_sub_categories', 'admin', 'faq_sub_category'],
            // [ '114', 'edit_faq_sub_categories', 'admin', 'faq_sub_category'],
            // [ '115', 'delete_faq_sub_categories', 'admin', 'faq_sub_category'],
            // [ '116', 'browse_faq_sub_categories', 'seller', 'faq_sub_category'],
            // [ '117', 'create_faq_sub_categories', 'seller', 'faq_sub_category'],
            // [ '118', 'edit_faq_sub_categories', 'seller', 'faq_sub_category'],
            // [ '119', 'delete_faq_sub_categories', 'seller', 'faq_sub_category'],

            // Faq policy
            [ '120', 'browse_faq_manager', 'admin', 'faq'],
            // [ '121', 'edit_faqs', 'admin', 'faq'],
            // [ '122', 'delete_faqs', 'admin', 'faq'],
            // [ '123', 'create_faqs', 'admin', 'faq'],
            // [ '124', 'browse_faq_manager', 'seller', 'faq'],
            // [ '125', 'create_faqs', 'seller', 'faq'],
            // [ '126', 'edit_faqs', 'seller', 'faq'],
            // [ '127', 'delete_faqs', 'seller', 'faq'],

            // Report policy
            [ '132', 'browse_reports', 'admin', 'report'],

        ];

        $modelHasRoles = [
            [1, 'App\\User', 1],
            [4, 'App\\User', 2],
            [4, 'App\\User', 3],
        ];

        $roleHasPermissions = [
            // [5, 7],
            // [25, 7],
            // [26, 7],
            // [27, 7],
            // [28, 7],
            // [29, 7],
            // [30, 7],
            // [31, 7],
            // [38, 7],
            // [39, 7],
            // [40, 7],
            // [52, 7],
            // [53, 7],
            // [54, 7],
            // [55, 7],
            // [56, 7],
            // [57, 7],
            // [58, 7],
            // [59, 7],
            // [60, 7],
            // [61, 7],
            // [62, 7],
            // [65, 7],
            // [66, 7],
            // [69, 7],
            // [70, 7],
            // [79, 7],
            // [80, 7],
            // [81, 7],
            // [82, 7],
            // [85, 7],
            // [87, 7],
            // [108, 7],
            // [109, 7],
            // [110, 7],
            // [111, 7],
            // [116, 7],
            // [117, 7],
            // [118, 7],
            // [119, 7],
            // [124, 7],
            // [125, 7],
            // [126, 7],
            // [125, 7],

            [1, 4],
            [2, 4],
            [3, 4],
            [4, 4],
            [6, 4],
            [7, 4],
            [8, 4],
            [9, 4],
            [10, 4],
            [11, 4],
            [12, 4],
            [13, 4],
            [14, 4],
            [15, 4],
            [16, 4],
            [17, 4],
            [18, 4],
            [19, 4],
            [20, 4],
            [21, 4],
            [22, 4],
            [23, 4],
            [24, 4],
            [32, 4],
            [33, 4],
            [34, 4],
            [35, 4],
            [36, 4],
            [37, 4],
            [41, 4],
            [42, 4],
            [43, 4],
            [44, 4],
            [45, 4],
            // [46, 4],
            // [47, 4],
            // [48, 4],
            // [49, 4],
            [50, 4],
            [51, 4],
            [63, 4],
            [64, 4],
            [67, 4],
            [68, 4],
            // [71, 4],
            // [72, 4],
            // [73, 4],
            // [74, 4],
            [75, 4],
            [76, 4],
            [77, 4],
            [78, 4],
            [83, 4],
            [84, 4],
            [86, 4],

            [88, 4],
            [89, 4],
            [90, 4],
            [91, 4],
            [92, 4],
            [93, 4],
            [94, 4],
            [95, 4],
            [96, 4],
            [97, 4],
            [98, 4],
            [99, 4],
            [100, 4],
            [101, 4],
            [102, 4],
            [103, 4],
            // [104, 4],
            // [105, 4],
            // [106, 4],
            // [107, 4],
            // [112, 4],
            // [113, 4],
            // [114, 4],
            // [115, 4],
            [120, 4],
            // [121, 4],
            // [122, 4],
            // [123, 4],
            [128, 4],
            [129, 4],
            [130, 4],
            [131, 4],
            [132, 4],

        ];
        foreach($roles as $role){
            DB::table('roles')->insert(
            ['id'=>$role[0],'name'=>$role[1],'guard_name'=>$role[2],'created_at'=>$role[3],'updated_at'=>$role[4]]
            );
        }
        foreach($permissions as $permission){
            DB::table('permissions')->insert(
            ['id'=>$permission[0], 'name'=>$permission[1], 'guard_name'=>$permission[2], 'type'=>$permission[3]]
            );
        }
        foreach($modelHasRoles as $model_role){
            DB::table('model_has_roles')->insert(
            ['role_id'=>$model_role[0],'model_type'=>$model_role[1],'model_id'=>$model_role[2]]
            );
        }
        foreach($roleHasPermissions as $role_permission){
            DB::table('role_has_permissions')->insert(
            ['permission_id'=>$role_permission[0],'role_id'=>$role_permission[1]]
            );
        }
    }
}
