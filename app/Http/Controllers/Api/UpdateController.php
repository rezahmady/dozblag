<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Codedge\Updater\UpdaterManager;
use Illuminate\Http\Request;
use Alert;

class UpdateController extends Controller
{
    public function check_update(UpdaterManager $updater): \Illuminate\Http\JsonResponse
    {
        if($updater->source()->isNewVersionAvailable()) {
            // Get the new version available
            $versionAvailable = $updater->source()->getVersionAvailable();
            return response()->json(['has_update' => true, 'version' => $versionAvailable]);
        } else {
            $version = $updater->source()->getVersionInstalled();
            return response()->json(['has_update' => false,  'version' => $version]);
        }
    }

    public function update(UpdaterManager $updater) {
        // Check if new version is available
        if($updater->source()->isNewVersionAvailable()) {

            // Get the current installed version
            $versionActive = $updater->source()->getVersionInstalled();

            // Get the new version available
            $versionAvailable = $updater->source()->getVersionAvailable();

            // Create a release
            $release = $updater->source()->fetch($versionAvailable);

            // Run the update process
            $updater->source()->update($release);

            Alert::success('تبریک! سیستم شما با موفقیت از ورژن '.$versionActive.' به ورژن '.$versionAvailable.' ارتقاء یافت.')->flash();
            return redirect()->back();
        } else {
            Alert::info('نسخه جدیدی برای نصب وجود ندارد!')->flash();
            return redirect()->back();
        }
    }
}
