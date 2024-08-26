<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['register'] = 'Login/register';
// $route['register/process'] = 'Login/save_employeeOne';

$route['forgetPassword'] = 'Login/forget_password';
$route['otpPassword'] = 'Login/otp_password';
$route['passwordSetup'] = 'Login/password_setup';

$route['Dashboard'] = 'Home';
$route['Setting'] = 'Home/setting_pages';
$route['uSetting'] = 'Home/user_setting_pages';
$route['uReport'] = 'Home/user_reports_pages';
$route['comProfile'] = 'Home/company_profile';
$route['aSetting'] = 'Home/account_setting';

$route['Category'] = 'Category';
$route['Unit'] = 'Category/product_units';

$route['subCategory'] = 'Category/sub_category_list';


$route['costType'] = 'Cost';

$route['uRole'] = 'User/user_role';
$route['User'] = 'User/user_list';

$route['Customer'] = 'Customer';
$route['custReport'] = 'Customer/all_customer_reports';
$route['custLedger'] = 'Customer/customer_ledger_report';

$route['Supplier'] = 'Supplier';
$route['supReport'] = 'Supplier/supplier_report';
$route['supLedger'] = 'Supplier/supplier_ledger';

$route['Employee'] = 'Employee/employee_information';

$route['Purchase'] = 'PurchaseOne';
$route['newPurchase'] = 'PurchaseOne/new_purchase';
$route['viewPurchase/(:num)'] = 'PurchaseOne/view_purchase/$1';
$route['viewPurchasePr/(:num)'] = 'PurchaseOne/view_purchasePr/$1';
$route['viewPurchaseLt/(:num)'] = 'PurchaseOne/view_purchaseLt/$1';


$route['editPurchase/(:num)'] = 'PurchaseOne/edit_purchase/$1';
$route['purchaseReport'] = 'PurchaseOne/purchases_reports';
$route['dpurReport'] = 'PurchaseOne/daily_purchases_reports';


$route['Product'] = 'Product';
$route['pBarcode/(:num)'] = 'Product/product_barcode/$1';
$route['storeProduct'] = 'Product/store_products_list';
$route['newSProduct'] = 'Product/new_store_product';
$route['newAProduct'] = 'Product/new_store_adjust';
$route['editSProduct/(:num)'] = 'Product/edit_store_product/$1';
$route['editAProduct/(:num)'] = 'Product/edit_store_adjust/$1';
$route['productAdjust'] = 'Product/products_adjust_list';
$route['stockReport'] = 'Product/product_reports';
$route['usedPReport'] = 'Product/product_used_reports';

$route['workOrder'] = 'Purchase';
$route['newWOrder'] = 'Purchase/new_purchase';
$route['viewWOrder/(:num)'] = 'Purchase/view_purchase/$1';
$route['editWOrder/(:num)'] = 'Purchase/edit_purchase/$1';
$route['orderReceive'] = 'Purchase/work_order_list';
$route['newOReceive'] = 'Purchase/purchase_order_receive';
$route['woReceive'] = 'Purchase/work_order_receive';
$route['viewWReceive/(:num)'] = 'Purchase/view_work_receive/$1';
$route['orderReport'] = 'Purchase/purchases_reports';
$route['receiveReport'] = 'Purchase/receive_order_reports';

$route['requisition'] = 'Sale';
$route['newRequisit'] = 'Sale/new_sale';
$route['viewReq/(:num)'] = 'Sale/view_invoice/$1';
$route['editReq/(:num)'] = 'Sale/edit_sale/$1';
$route['approveReq/(:num)'] = 'Sale/approve_sales/$1';
$route['delivery'] = 'Sale/delivery_list';
$route['newDelivery'] = 'Sale/new_delivery';
$route['searchDelivery'] = 'Sale/search_delivery';
$route['viewDelivery/(:num)'] = 'Sale/view_delivery/$1';
$route['reqReport'] = 'Sale/all_sales_reports';
$route['devReport'] = 'Sale/requisition_delivery_reports';

$route['sale'] = 'SaleOne';
$route['newSale'] = 'SaleOne/new_sale_one';
$route['viewSale/(:num)'] = 'SaleOne/view_invoice_one/$1';
$route['editSaleOne/(:num)'] = 'SaleOne/edit_sale_one/$1';

$route['refund'] = 'Returns';
$route['newReturn'] = 'Returns/new_return';
$route['viewReturn/(:num)'] = 'Returns/view_return/$1';
$route['approveRef/(:num)'] = 'Returns/approve_refund/$1';

$route['userAccess'] = 'Access_setup/user_access_setup';
$route['viewUAccess/(:num)'] = 'Access_setup/view_uaccess_setup/$1';
$route['editUAccess/(:num)'] = 'Access_setup/edit_uaccess_setup/$1';













$route['Voucher'] = 'Voucher';
$route['newVoucher'] = 'Voucher/new_voucher';
$route['viewVoucher/(:num)'] = 'Voucher/voucher_details/$1';
$route['editVoucher/(:num)'] = 'Voucher/voucher_edit/$1';
$route['vReports'] = 'Voucher/voucher_report';

