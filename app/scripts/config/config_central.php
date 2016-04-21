<?php
namespace Transvision;

$moz_repo_dirs = [
    'browser/branding/official/locales/en-US' => 'browser/branding/official',
    'browser/locales/en-US'                   => 'browser',
    'browser/extensions/pocket/locales/en-US' => 'browser/extensions/pocket',
    'devtools/client/locales/en-US'           => 'devtools/client',
    'devtools/shared/locales/en-US'           => 'devtools/shared',
    'dom/locales/en-US'                       => 'dom',
    'embedding/android/locales/en-US'         => 'embedding/android',
    'mobile/android/base/locales/en-US'       => 'mobile/android/base',
    'mobile/android/locales/en-US/chrome'     => 'mobile/android/chrome',
    'mobile/locales/en-US'                    => 'mobile',
    'netwerk/locales/en-US'                   => 'netwerk',
    'security/manager/locales/en-US/chrome'   => 'security/manager/chrome',
    'services/sync/locales/en-US'             => 'services/sync',
    'toolkit/locales/en-US'                   => 'toolkit',
    'webapprt/locales/en-US'                  => 'webapprt',
];
// If we want to include en-US dic history: extensions/spellcheck/locales/en-US
// Not sure we want to handle that… (from CVS, removed in sept 2008) http://hg.mozilla.org/mozilla-central/file/9b2a99adc05e/embedding/browser/chrome/locale/en-US

$comm_repo_dirs = [
    'calendar/locales/en-US'                            => 'calendar',
    'chat/locales/en-US'                                => 'chat',
    'editor/ui/locales/en-US/chrome'                    => 'editor/ui/chrome',
    'mail/locales/en-US'                                => 'mail',
    'other-licenses/branding/thunderbird/locales/en-US' => 'other-licenses/branding/thunderbird',
    'other-licenses/branding/sunbird/locales/en-US'     => 'other-licenses/branding/sunbird',
    'suite/locales/en-US'                               => 'suite',
];

$target_repo = 'en-US-central';
$moz_repo = new HgRepo(HG . 'TRUNK_EN-US/mozilla-central');
$moz_repo->short_name  = 'mozilla-central';
$moz_repo->web_link    = 'mozilla-central';
$moz_repo->origin      = 'Mozilla Central';
$moz_repo->repo_dirs   = $moz_repo_dirs;
$moz_repo->save_latest = CACHE_PATH . 'latest_' . $moz_repo->short_name . '.txt';

$comm_repo = new HgRepo(HG . 'TRUNK_EN-US/comm-central');
$comm_repo->short_name  = 'comm-central';
$comm_repo->web_link    = 'comm-central';
$comm_repo->origin      = 'Comm Central';
$comm_repo->repo_dirs   = $comm_repo_dirs;
$comm_repo->save_latest = CACHE_PATH . 'latest_' . $comm_repo->short_name . '.txt';
