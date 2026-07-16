<?php

namespace Modules\TraficPermit\Providers;

use Illuminate\Support\ServiceProvider;
use TorMorten\Eventy\Facades\Events as Hook;

class HookServiceProvider extends ServiceProvider
{

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        /**
         *  Admin menu
         */
        Hook::addAction('admin-menu-build', function($menu) {
            if(
                backpack_user()->can('Country list') or
                backpack_user()->can('Repository list') or
                backpack_user()->can('TraficPermit list') or
                backpack_user()->can('TraficPermitType list') or
                backpack_user()->can('TraficPermitTemplate list') 
                ) {
                $menu->add("repository", 'دبیرخانه' , '#' , 700, "folder");

                if(backpack_user()->can('TraficPermit list'))
                $menu->add("repository.trafic_permit", trans("traficpermit::traficpermit.trafic_permit_plural") , backpack_url("trafic-permit") , 730, "clipboard-list");

                if(backpack_user()->can('Country list'))
                $menu->add("repository.country", trans("traficpermit::traficpermit.country_plural") , backpack_url("country") , 700, "globe");

                if(backpack_user()->can('Repository list'))
                $menu->add("repository.repository", trans("traficpermit::traficpermit.repository_plural") , backpack_url("repository") , 720, "box");

                if(backpack_user()->can('TraficPermitTemplate list'))
                $menu->add("repository.trafic_permit_template", trans("traficpermit::traficpermit.trafic_permit_template_plural") , backpack_url("trafic-permit-template") , 730, "print");

                if(backpack_user()->can('TraficPermitType list'))
                $menu->add("repository.trafic_permit_type", trans("traficpermit::traficpermit.trafic_permit_type_plural") , backpack_url("trafic-permit-type") , 740, "folder");

            }

            if(
                backpack_user()->can('TraficPermitReport list') or
                backpack_user()->can('PermitReport list') or
                backpack_user()->can('TotalTraficPermitReport list') or
                (backpack_user()->can('TraficPermitTransaction list') and !backpack_user()->can('TraficPermitTransaction manage all')) or
                backpack_user()->can('corrected_export list')
                ) {

                    $menu->add("exports", 'گزارشات' , '#' , 800, "chart-pie");

                    if(backpack_user()->can('TraficPermitReport list'))
                    $menu->add("exports.trafic_permit", trans("traficpermit::traficpermit.trafic_permit_plural") , backpack_url("trafic-permit-report") , 700, "clipboard-list");

                    if(backpack_user()->can('TraficPermitExport list'))
                    $menu->add("exports.trafic_permit_export", trans("traficpermit::traficpermit.trafic_permit_export_plural") , backpack_url("trafic-permit-export") , 700, "print");

                    if(backpack_user()->can('CorrectedExport list'))
                    $menu->add("exports.corrected_export", trans("traficpermit::traficpermit.corrected_export_plural") , backpack_url("corrected-export") , 700, "retweet");

                    if(backpack_user()->can('TraficPermitTransaction list') and !backpack_user()->can('TraficPermitTransaction manage all'))
                    $menu->add("exports.transaction", trans("traficpermit::traficpermit.transaction_plural") , backpack_url("transaction") , 1000, "funnel-dollar");

                }

            if(backpack_user()->can('PermitOrder list'))
            $menu->add("permit_order", trans("traficpermit::traficpermit.permit_order_plural") , backpack_url("permit-order") , 900, "file-alt");

            if(backpack_user()->can('TraficPermitGeneral setting'))
            $menu->add("trafic_permit_general", 'تنظیمات کلی' , backpack_url("trafic-permit-general/setting") , 950, "cogs");

            if(backpack_user()->can('TraficPermitTransaction manage all'))
            $menu->add("transaction", trans("traficpermit::traficpermit.transaction_plural") , backpack_url("transaction") , 1000, "funnel-dollar");
            // this should be the absolute last line of admin menu
        }, 20, 1);

        /**
         *  Admin widgets
         *
        */

        Hook::addFilter('admin-dashboard-widget::filter', function($widgets) {
            if(backpack_user()->can('TotalTraficPermitReport list')) {
                $widget = [
                    'id'  => 'total-repository-report',
                    'lg'  => 'col-lg-12',
                    'md'  => 'col-md-12',
                    'sm'  => 'col-sm-12',
                    'xsm' => 'col-12',
                    'view' => 'traficpermit-widget-total-repository-report',
                    'active' => true,
                ];
    
                array_push($widgets, $widget);
            }
            return $widgets;
        }, 20, 1);

        Hook::addFilter('admin-dashboard-widget::filter', function($widgets) {
            if(backpack_user()->unity) {
                $widget = [
                    'id'  => 'traficpermit-count',
                    'lg'  => 'col-lg-3',
                    'md'  => 'col-md-3',
                    'sm'  => 'col-sm-12',
                    'xsm' => 'col-12',
                    'view' => 'traficpermit-widget-count',
                    'active' => true,
                ];

                array_push($widgets, $widget);
            }

            if(backpack_user()->unity) {
                $widget = [
                    'id'  => 'wallet',
                    'lg'  => 'col-lg-3',
                    'md'  => 'col-md-3',
                    'sm'  => 'col-sm-12',
                    'xsm' => 'col-12',
                    'view' => 'traficpermit-widget-wallet',
                    'active' => true,
                ];

                array_push($widgets, $widget);
            }
            return $widgets;
        }, 20, 1);
    }

}