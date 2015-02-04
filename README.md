# vpsmon
A VPS monitor written in PHP that calls SolusVM API.

Brought to you by http://du9l.com

## how to use
1. Acquire API key and hash from your SolusVM control panel. One pair of key/hash is for one VPS exclusively.
2. Fill your desired `vps-name` (non-repetitive), control panel's domain, key and hash into the `$api` array in `config.php`. You can put multiple APIs from same / different hosting companies.
3. Upload at least `index.php`, `solusvm.php` and `config.php` to your PHP hosting space. You also need CURL enabled to use them.
4. Visit `index.php?name=vps-name` to show the data returned by API. You can also click on `boot` there.

## how to develop
* It's very easy to copy/paste/modify `boot` to other actions like `reboot` or `shutdown`. Refer to [SolusVM Docs](https://documentation.solusvm.com/display/DOCS/Functions) for more API information.
* Alternatively you can call `solusvm` function in `solusvm.php`.

## cron job
* You can use a crontab or online cron service to periodically call `cron.php` (e.g. you can use `wget` on Linux). It automatically calls all APIs' `boot` action and return `ok` if succeeded.
* This prevents your boxes from getting offline (if they are online, `boot` action won't do anything). You can switch to `reboot` if you want them to reboot once in a while.

## note
This is a convenience tool for me (and hopefully for you) so no speed (like cache) or security is taken into consideration. Please use it wisely and with care. That is to say, if you open a non-password-protected entry for `shutdown`, anyone who discovers it can take down your box with it.

## license
* [MIT LICENSE](LICENSE)
