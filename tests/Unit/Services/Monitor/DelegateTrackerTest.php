<?php

declare(strict_types=1);

use App\Models\Block;
use App\Models\Round;
use App\Models\Wallet;
use App\Services\Monitor\DelegateTracker;
use Illuminate\Support\Facades\Cache;

use function Spatie\Snapshots\assertMatchesSnapshot;

it('should calculate the forging order', function () {
    Wallet::factory(51)->create()->each(function ($wallet) {
        Round::factory()->create([
            'round'      => '112168',
            'public_key' => $wallet->public_key,
        ]);

        Cache::tags(['delegates'])->put($wallet->public_key, $wallet);
        Cache::put('lastBlock:'.$wallet->public_key, []);
    });

    // Start height for round 112168
    Block::factory()->create([
        'height'    => 5720517,
        'timestamp' => 113620816,
    ]);

    Block::factory()->create([
        'height'    => 5720529,
        'timestamp' => 113620904,
    ]);

    $activeDelegates = collect([
        (object) ['public_key' => '033a5474f68f92f254691e93c06a2f22efaf7d66b543a53efcece021819653a200'],
        (object) ['public_key' => '0215789ac26155b7a338708f595b97c453e08918d0630c896cbd31d83fe2ad1c33'],
        (object) ['public_key' => '03d60e675b8a4b461361689e29fcf809cc4724de57ad7e7f73825e16d7b092d338'],
        (object) ['public_key' => '029918d8fe6a78cc01bbab31f636494568dd954431f75f4ea6ff1da040b7063a70'],
        (object) ['public_key' => '03ccf15ff3a07e1a4b04692f7f2db3a06948708dacfff47661c259f2fa689e1941'],
        (object) ['public_key' => '035c14e8c5f0ee049268c3e75f02f05b4246e746dc42f99271ff164b7be20cf5b8'],
        (object) ['public_key' => '03d3c6889608074b44155ad2e6577c3368e27e6e129c457418eb3e5ed029544e8d'],
        (object) ['public_key' => '02062f6f6d2aabafd745e6b01f4aa788a012c4ce7131312026bdb6eb4e74a464d2'],
        (object) ['public_key' => '027716e659220085e41389efc7cf6a05f7f7c659cf3db9126caabce6cda9156582'],
        (object) ['public_key' => '0352e9ea81b7fb78b80ab6598e66d23764249c77b9492e3c1b0705d9d0722b729f'],
        (object) ['public_key' => '037850667ea2c8473adf7c87ee4496af1b7821f4e10761e78c3b391d6fcfbde9bb'],
        (object) ['public_key' => '02ac8d84d81648154f79ba64fbf64cd6ee60f385b2aa52e8eb72bc1374bf55a68c'],
        (object) ['public_key' => '032cfbb18f4e49952c6d6475e8adc6d0cba00b81ef6606cc4927b78c6c50558beb'],
        (object) ['public_key' => '0242555e90957de10e3912ce8831bcc985a40a645447dbfe8a0913ee6d89914707'],
        (object) ['public_key' => '02677f73453da6073f5cf76db8f65fabc1a3b7aadc7b06027e0df709f14e097790'],
        (object) ['public_key' => '0236d5232cdbd1e7ab87fad10ebe689c4557bc9d0c408b6773be964c837231d5f0'],
        (object) ['public_key' => '02789894f309f08a4e7833452552aa39e168005d893cafc8ef995edbfdba396d2c'],
        (object) ['public_key' => '03f3512aa9717b2ca83d371ed3bb2d3ff922969f3ceef92f65c060afa2bc2244fb'],
        (object) ['public_key' => '039b5a3a71335bfa6c72b82498f814123e0678f7cd3d8e7221ec7124918736e01c'],
        (object) ['public_key' => '023ee98f453661a1cb765fd60df95b4efb1e110660ffb88ae31c2368a70f1f7359'],
        (object) ['public_key' => '02e345079aca0567db96ec0ba3acf859b7cfd15134a855671f9c0fe8b1173767bd'],
        (object) ['public_key' => '0304d0c477d634cc85d89c1a4afee8f51168d1747fe8fd79cabc26565e49eb8a7a'],
        (object) ['public_key' => '0284a88da69cc04439633217c6961d2800df0f7dff7f85b9803848ee02d0743f1d'],
        (object) ['public_key' => '02d2f48a7ebb5b6d484de15b4cab8ab13c1d39b7141301efe048714aa9d82eb1cd'],
        (object) ['public_key' => '03380be01971b9f58131974234d466adca4889cb8e9616d64166980370e6bf1157'],
        (object) ['public_key' => '024d5eacc5e05e1b05c476b367b7d072857826d9b271e07d3a3327224db8892a21'],
        (object) ['public_key' => '02747353898e59c4f784542f357d5dd938a2872adb53abb94924091fddfdd83dc3'],
        (object) ['public_key' => '037997a6553ea8073eb199e9f5ff23b8f0892e79433ef35e13966e0a12849d02e3'],
        (object) ['public_key' => '02d0244d939fad9004cc104f71b46b428d903e4f2988a65f39fdaa1b7482894c9e'],
        (object) ['public_key' => '023e3b421c730f85d2db546ee58f2b8d81dc141c3b12f8b8efadba8ddf085a4db6'],
        (object) ['public_key' => '03b12f99375c3b0e4f5f5c7ea74e723f0b84a6f169b47d9105ed2a179f30c82df2'],
        (object) ['public_key' => '025341ecfcbb48f9ecac8b87d6e5ace9fb172cee9c521a036f20861f515077bfc3'],
        (object) ['public_key' => '02cd9f56a176c843724eb58d3ef89dc88915a814bdcf284b02933e0dd203630a83'],
        (object) ['public_key' => '031a6d8dab63668e901661c592dfe4bcc75793959d6ee6300408482840487d1faf'],
        (object) ['public_key' => '02257c58004e5ae23716d1c44beea0cca7f5b522a692df367bae9015a4f15c1670'],
        (object) ['public_key' => '022ffb5fa4eb5b2e71c985b1d796642528802f04a6ddf9a449ba1aab292a9744aa'],
        (object) ['public_key' => '03153c994e5306b2fbba9bb533f22871e12e4c1d1d3960d1eeef385ab143b258b4'],
        (object) ['public_key' => '02951227bb3bc5309aeb96460dbdf945746012810bb4020f35c20feae4eea7e5d4'],
        (object) ['public_key' => '0296893488d335ff818391da7c450cfeb7821a4eb535b15b95808ea733915fbfb1'],
        (object) ['public_key' => '0250b742256f9321bd7d46f3ed9769b215a7c2fb02be951acf43bc51eb57ceadf6'],
        (object) ['public_key' => '03b906102928cf97c6ddeb59cefb0e1e02105a22ab1acc3b4906214a16d494db0a'],
        (object) ['public_key' => '03dcb84917cf6d7b742f58c04693c5e00c56a4ae83feec129b3e3cc27111796232'],
        (object) ['public_key' => '02c3d1ae1b8fe831218f78cf09d864e60818ebdba4aacc74ecc2bcf2734aadf5ea'],
        (object) ['public_key' => '0306950dae7158103814e3828b1ab97a87dbb3680db1b4c6998b8208865b2f9db7'],
        (object) ['public_key' => '022eedf9f1cdae0cfaae635fe415b6a8f1912bc89bc3880ec41135d62cbbebd3d3'],
        (object) ['public_key' => '02adfadcf8b9c8c1925c8662ac9cde0763c92b06404dfffad8555f41638cdf4780'],
        (object) ['public_key' => '03ce92e54f9dbb5e4a050edddf5862dee29f419c60ceaad052d50aad6fcced5652'],
        (object) ['public_key' => '03a8ff0a3cbdcb3bfbdb84dbf83226f338ba1452047ac5b8228a1513f7f1de80de'],
        (object) ['public_key' => '02e311d97f92dc879860ec0d63b344239f17149ed1700b279b5ef52d2baaa0226f'],
        (object) ['public_key' => '03eda1b9127d9a12a7c6903ca896534937ec492afa12ffa57a9aa6f3c77b618fdb'],
        (object) ['public_key' => '03f6af8c750b9d29d9da3d4ddf5818a1fcdd4558ba0dde731f9c4b17bcbdcd83f2'],
    ]);

    assertMatchesSnapshot(DelegateTracker::execute($activeDelegates, 5720517));
});
