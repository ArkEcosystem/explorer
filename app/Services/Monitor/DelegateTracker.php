<?php

declare(strict_types=1);

namespace App\Services\Monitor;

use App\Facades\Network;
use App\Models\Block;
use Illuminate\Support\Collection;

final class DelegateTracker
{
    const EXPECTED = [
        'input' => [
            '033a5474f68f92f254691e93c06a2f22efaf7d66b543a53efcece021819653a200',
            '0215789ac26155b7a338708f595b97c453e08918d0630c896cbd31d83fe2ad1c33',
            '03d60e675b8a4b461361689e29fcf809cc4724de57ad7e7f73825e16d7b092d338',
            '029918d8fe6a78cc01bbab31f636494568dd954431f75f4ea6ff1da040b7063a70',
            '03ccf15ff3a07e1a4b04692f7f2db3a06948708dacfff47661c259f2fa689e1941',
            '035c14e8c5f0ee049268c3e75f02f05b4246e746dc42f99271ff164b7be20cf5b8',
            '03d3c6889608074b44155ad2e6577c3368e27e6e129c457418eb3e5ed029544e8d',
            '02062f6f6d2aabafd745e6b01f4aa788a012c4ce7131312026bdb6eb4e74a464d2',
            '027716e659220085e41389efc7cf6a05f7f7c659cf3db9126caabce6cda9156582',
            '0352e9ea81b7fb78b80ab6598e66d23764249c77b9492e3c1b0705d9d0722b729f',
            '037850667ea2c8473adf7c87ee4496af1b7821f4e10761e78c3b391d6fcfbde9bb',
            '02ac8d84d81648154f79ba64fbf64cd6ee60f385b2aa52e8eb72bc1374bf55a68c',
            '032cfbb18f4e49952c6d6475e8adc6d0cba00b81ef6606cc4927b78c6c50558beb',
            '0242555e90957de10e3912ce8831bcc985a40a645447dbfe8a0913ee6d89914707',
            '02677f73453da6073f5cf76db8f65fabc1a3b7aadc7b06027e0df709f14e097790',
            '0236d5232cdbd1e7ab87fad10ebe689c4557bc9d0c408b6773be964c837231d5f0',
            '02789894f309f08a4e7833452552aa39e168005d893cafc8ef995edbfdba396d2c',
            '03f3512aa9717b2ca83d371ed3bb2d3ff922969f3ceef92f65c060afa2bc2244fb',
            '039b5a3a71335bfa6c72b82498f814123e0678f7cd3d8e7221ec7124918736e01c',
            '023ee98f453661a1cb765fd60df95b4efb1e110660ffb88ae31c2368a70f1f7359',
            '02e345079aca0567db96ec0ba3acf859b7cfd15134a855671f9c0fe8b1173767bd',
            '0304d0c477d634cc85d89c1a4afee8f51168d1747fe8fd79cabc26565e49eb8a7a',
            '0284a88da69cc04439633217c6961d2800df0f7dff7f85b9803848ee02d0743f1d',
            '02d2f48a7ebb5b6d484de15b4cab8ab13c1d39b7141301efe048714aa9d82eb1cd',
            '03380be01971b9f58131974234d466adca4889cb8e9616d64166980370e6bf1157',
            '024d5eacc5e05e1b05c476b367b7d072857826d9b271e07d3a3327224db8892a21',
            '02747353898e59c4f784542f357d5dd938a2872adb53abb94924091fddfdd83dc3',
            '037997a6553ea8073eb199e9f5ff23b8f0892e79433ef35e13966e0a12849d02e3',
            '02d0244d939fad9004cc104f71b46b428d903e4f2988a65f39fdaa1b7482894c9e',
            '023e3b421c730f85d2db546ee58f2b8d81dc141c3b12f8b8efadba8ddf085a4db6',
            '03b12f99375c3b0e4f5f5c7ea74e723f0b84a6f169b47d9105ed2a179f30c82df2',
            '025341ecfcbb48f9ecac8b87d6e5ace9fb172cee9c521a036f20861f515077bfc3',
            '02cd9f56a176c843724eb58d3ef89dc88915a814bdcf284b02933e0dd203630a83',
            '031a6d8dab63668e901661c592dfe4bcc75793959d6ee6300408482840487d1faf',
            '02257c58004e5ae23716d1c44beea0cca7f5b522a692df367bae9015a4f15c1670',
            '022ffb5fa4eb5b2e71c985b1d796642528802f04a6ddf9a449ba1aab292a9744aa',
            '03153c994e5306b2fbba9bb533f22871e12e4c1d1d3960d1eeef385ab143b258b4',
            '02951227bb3bc5309aeb96460dbdf945746012810bb4020f35c20feae4eea7e5d4',
            '0296893488d335ff818391da7c450cfeb7821a4eb535b15b95808ea733915fbfb1',
            '0250b742256f9321bd7d46f3ed9769b215a7c2fb02be951acf43bc51eb57ceadf6',
            '03b906102928cf97c6ddeb59cefb0e1e02105a22ab1acc3b4906214a16d494db0a',
            '03dcb84917cf6d7b742f58c04693c5e00c56a4ae83feec129b3e3cc27111796232',
            '02c3d1ae1b8fe831218f78cf09d864e60818ebdba4aacc74ecc2bcf2734aadf5ea',
            '0306950dae7158103814e3828b1ab97a87dbb3680db1b4c6998b8208865b2f9db7',
            '022eedf9f1cdae0cfaae635fe415b6a8f1912bc89bc3880ec41135d62cbbebd3d3',
            '02adfadcf8b9c8c1925c8662ac9cde0763c92b06404dfffad8555f41638cdf4780',
            '03ce92e54f9dbb5e4a050edddf5862dee29f419c60ceaad052d50aad6fcced5652',
            '03a8ff0a3cbdcb3bfbdb84dbf83226f338ba1452047ac5b8228a1513f7f1de80de',
            '02e311d97f92dc879860ec0d63b344239f17149ed1700b279b5ef52d2baaa0226f',
            '03eda1b9127d9a12a7c6903ca896534937ec492afa12ffa57a9aa6f3c77b618fdb',
            '03f6af8c750b9d29d9da3d4ddf5818a1fcdd4558ba0dde731f9c4b17bcbdcd83f2',
        ],
        'seeds'  => [
            '2fc4a087ad1e561ad165973b61ab8d6e29df3becd6b3ca341e03baf506950da8',
            '227e4fc752b161715ddbf838571d56101ab542b52648fc8d59e452615be56801',
            'aeb502c7857e78bbde89dbe8d8bbf0275b57a4af528fa66cf57c4e5105d72dc7',
            '691a10ca9120e50a2bdf27478c4a2c6baa247acdfdf24661315a3c3f91d56be2',
            '330bf5130d2aaa35ba75a613d338f3e8b08f89948ee6a8f5b1326d7029db8ccb',
            '9bb77d6f29de8581bad156797683298bb9f3df1e594d8e541c03037b26a934a3',
            'f429b7ef4a7fd90971a77ebe192ade005627312e12c7f562ae5b712008c03621',
            '11b17d13fa81cb0376a836d626ec3e56662c47df08d396b0a54743dbe266b7c8',
            'd82dcb753503199e38df3d229db24ac1a585145e045db6693bf80017116e2b18',
            'c33765b12c768b5936fa972169095c2206ce4fa5a04a07bc4e00c861216d70a8',
            'f9bda56832cb0ee94238dc22b22eaaa4312f2da2125f5e24a295d7c61c3859ac',
        ],
        'output' => [
            '02e345079aca0567db96ec0ba3acf859b7cfd15134a855671f9c0fe8b1173767bd',
            '0306950dae7158103814e3828b1ab97a87dbb3680db1b4c6998b8208865b2f9db7',
            '024d5eacc5e05e1b05c476b367b7d072857826d9b271e07d3a3327224db8892a21',
            '0236d5232cdbd1e7ab87fad10ebe689c4557bc9d0c408b6773be964c837231d5f0',
            '0242555e90957de10e3912ce8831bcc985a40a645447dbfe8a0913ee6d89914707',
            '02257c58004e5ae23716d1c44beea0cca7f5b522a692df367bae9015a4f15c1670',
            '03380be01971b9f58131974234d466adca4889cb8e9616d64166980370e6bf1157',
            '02d0244d939fad9004cc104f71b46b428d903e4f2988a65f39fdaa1b7482894c9e',
            '03ce92e54f9dbb5e4a050edddf5862dee29f419c60ceaad052d50aad6fcced5652',
            '02ac8d84d81648154f79ba64fbf64cd6ee60f385b2aa52e8eb72bc1374bf55a68c',
            '0304d0c477d634cc85d89c1a4afee8f51168d1747fe8fd79cabc26565e49eb8a7a',
            '037850667ea2c8473adf7c87ee4496af1b7821f4e10761e78c3b391d6fcfbde9bb',
            '02789894f309f08a4e7833452552aa39e168005d893cafc8ef995edbfdba396d2c',
            '027716e659220085e41389efc7cf6a05f7f7c659cf3db9126caabce6cda9156582',
            '02677f73453da6073f5cf76db8f65fabc1a3b7aadc7b06027e0df709f14e097790',
            '0215789ac26155b7a338708f595b97c453e08918d0630c896cbd31d83fe2ad1c33',
            '03f3512aa9717b2ca83d371ed3bb2d3ff922969f3ceef92f65c060afa2bc2244fb',
            '029918d8fe6a78cc01bbab31f636494568dd954431f75f4ea6ff1da040b7063a70',
            '03eda1b9127d9a12a7c6903ca896534937ec492afa12ffa57a9aa6f3c77b618fdb',
            '0296893488d335ff818391da7c450cfeb7821a4eb535b15b95808ea733915fbfb1',
            '03a8ff0a3cbdcb3bfbdb84dbf83226f338ba1452047ac5b8228a1513f7f1de80de',
            '03d60e675b8a4b461361689e29fcf809cc4724de57ad7e7f73825e16d7b092d338',
            '03dcb84917cf6d7b742f58c04693c5e00c56a4ae83feec129b3e3cc27111796232',
            '02951227bb3bc5309aeb96460dbdf945746012810bb4020f35c20feae4eea7e5d4',
            '02e311d97f92dc879860ec0d63b344239f17149ed1700b279b5ef52d2baaa0226f',
            '032cfbb18f4e49952c6d6475e8adc6d0cba00b81ef6606cc4927b78c6c50558beb',
            '03b12f99375c3b0e4f5f5c7ea74e723f0b84a6f169b47d9105ed2a179f30c82df2',
            '023ee98f453661a1cb765fd60df95b4efb1e110660ffb88ae31c2368a70f1f7359',
            '0352e9ea81b7fb78b80ab6598e66d23764249c77b9492e3c1b0705d9d0722b729f',
            '023e3b421c730f85d2db546ee58f2b8d81dc141c3b12f8b8efadba8ddf085a4db6',
            '02cd9f56a176c843724eb58d3ef89dc88915a814bdcf284b02933e0dd203630a83',
            '0284a88da69cc04439633217c6961d2800df0f7dff7f85b9803848ee02d0743f1d',
            '03b906102928cf97c6ddeb59cefb0e1e02105a22ab1acc3b4906214a16d494db0a',
            '022ffb5fa4eb5b2e71c985b1d796642528802f04a6ddf9a449ba1aab292a9744aa',
            '035c14e8c5f0ee049268c3e75f02f05b4246e746dc42f99271ff164b7be20cf5b8',
            '02747353898e59c4f784542f357d5dd938a2872adb53abb94924091fddfdd83dc3',
            '03d3c6889608074b44155ad2e6577c3368e27e6e129c457418eb3e5ed029544e8d',
            '037997a6553ea8073eb199e9f5ff23b8f0892e79433ef35e13966e0a12849d02e3',
            '02d2f48a7ebb5b6d484de15b4cab8ab13c1d39b7141301efe048714aa9d82eb1cd',
            '0250b742256f9321bd7d46f3ed9769b215a7c2fb02be951acf43bc51eb57ceadf6',
            '02062f6f6d2aabafd745e6b01f4aa788a012c4ce7131312026bdb6eb4e74a464d2',
            '02adfadcf8b9c8c1925c8662ac9cde0763c92b06404dfffad8555f41638cdf4780',
            '025341ecfcbb48f9ecac8b87d6e5ace9fb172cee9c521a036f20861f515077bfc3',
            '031a6d8dab63668e901661c592dfe4bcc75793959d6ee6300408482840487d1faf',
            '022eedf9f1cdae0cfaae635fe415b6a8f1912bc89bc3880ec41135d62cbbebd3d3',
            '033a5474f68f92f254691e93c06a2f22efaf7d66b543a53efcece021819653a200',
            '03ccf15ff3a07e1a4b04692f7f2db3a06948708dacfff47661c259f2fa689e1941',
            '02c3d1ae1b8fe831218f78cf09d864e60818ebdba4aacc74ecc2bcf2734aadf5ea',
            '03153c994e5306b2fbba9bb533f22871e12e4c1d1d3960d1eeef385ab143b258b4',
            '039b5a3a71335bfa6c72b82498f814123e0678f7cd3d8e7221ec7124918736e01c',
            '03f6af8c750b9d29d9da3d4ddf5818a1fcdd4558ba0dde731f9c4b17bcbdcd83f2',
        ],
    ];

    // [2020-10-26 14:12:08.432] WARNING: {
    //     "method": "delegates",
    //     "result": [
    //         "033a5474f68f92f254691e93c06a2f22efaf7d66b543a53efcece021819653a200",
    //         "0215789ac26155b7a338708f595b97c453e08918d0630c896cbd31d83fe2ad1c33",
    //         "03d60e675b8a4b461361689e29fcf809cc4724de57ad7e7f73825e16d7b092d338",
    //         "029918d8fe6a78cc01bbab31f636494568dd954431f75f4ea6ff1da040b7063a70",
    //         "03ccf15ff3a07e1a4b04692f7f2db3a06948708dacfff47661c259f2fa689e1941",
    //         "035c14e8c5f0ee049268c3e75f02f05b4246e746dc42f99271ff164b7be20cf5b8",
    //         "03d3c6889608074b44155ad2e6577c3368e27e6e129c457418eb3e5ed029544e8d",
    //         "02062f6f6d2aabafd745e6b01f4aa788a012c4ce7131312026bdb6eb4e74a464d2",
    //         "027716e659220085e41389efc7cf6a05f7f7c659cf3db9126caabce6cda9156582",
    //         "0352e9ea81b7fb78b80ab6598e66d23764249c77b9492e3c1b0705d9d0722b729f",
    //         "037850667ea2c8473adf7c87ee4496af1b7821f4e10761e78c3b391d6fcfbde9bb",
    //         "02ac8d84d81648154f79ba64fbf64cd6ee60f385b2aa52e8eb72bc1374bf55a68c",
    //         "032cfbb18f4e49952c6d6475e8adc6d0cba00b81ef6606cc4927b78c6c50558beb",
    //         "0242555e90957de10e3912ce8831bcc985a40a645447dbfe8a0913ee6d89914707",
    //         "02677f73453da6073f5cf76db8f65fabc1a3b7aadc7b06027e0df709f14e097790",
    //         "0236d5232cdbd1e7ab87fad10ebe689c4557bc9d0c408b6773be964c837231d5f0",
    //         "02789894f309f08a4e7833452552aa39e168005d893cafc8ef995edbfdba396d2c",
    //         "03f3512aa9717b2ca83d371ed3bb2d3ff922969f3ceef92f65c060afa2bc2244fb",
    //         "039b5a3a71335bfa6c72b82498f814123e0678f7cd3d8e7221ec7124918736e01c",
    //         "023ee98f453661a1cb765fd60df95b4efb1e110660ffb88ae31c2368a70f1f7359",
    //         "02e345079aca0567db96ec0ba3acf859b7cfd15134a855671f9c0fe8b1173767bd",
    //         "0304d0c477d634cc85d89c1a4afee8f51168d1747fe8fd79cabc26565e49eb8a7a",
    //         "0284a88da69cc04439633217c6961d2800df0f7dff7f85b9803848ee02d0743f1d",
    //         "02d2f48a7ebb5b6d484de15b4cab8ab13c1d39b7141301efe048714aa9d82eb1cd",
    //         "03380be01971b9f58131974234d466adca4889cb8e9616d64166980370e6bf1157",
    //         "024d5eacc5e05e1b05c476b367b7d072857826d9b271e07d3a3327224db8892a21",
    //         "02747353898e59c4f784542f357d5dd938a2872adb53abb94924091fddfdd83dc3",
    //         "037997a6553ea8073eb199e9f5ff23b8f0892e79433ef35e13966e0a12849d02e3",
    //         "02d0244d939fad9004cc104f71b46b428d903e4f2988a65f39fdaa1b7482894c9e",
    //         "023e3b421c730f85d2db546ee58f2b8d81dc141c3b12f8b8efadba8ddf085a4db6",
    //         "03b12f99375c3b0e4f5f5c7ea74e723f0b84a6f169b47d9105ed2a179f30c82df2",
    //         "025341ecfcbb48f9ecac8b87d6e5ace9fb172cee9c521a036f20861f515077bfc3",
    //         "02cd9f56a176c843724eb58d3ef89dc88915a814bdcf284b02933e0dd203630a83",
    //         "031a6d8dab63668e901661c592dfe4bcc75793959d6ee6300408482840487d1faf",
    //         "02257c58004e5ae23716d1c44beea0cca7f5b522a692df367bae9015a4f15c1670",
    //         "022ffb5fa4eb5b2e71c985b1d796642528802f04a6ddf9a449ba1aab292a9744aa",
    //         "03153c994e5306b2fbba9bb533f22871e12e4c1d1d3960d1eeef385ab143b258b4",
    //         "02951227bb3bc5309aeb96460dbdf945746012810bb4020f35c20feae4eea7e5d4",
    //         "0296893488d335ff818391da7c450cfeb7821a4eb535b15b95808ea733915fbfb1",
    //         "0250b742256f9321bd7d46f3ed9769b215a7c2fb02be951acf43bc51eb57ceadf6",
    //         "03b906102928cf97c6ddeb59cefb0e1e02105a22ab1acc3b4906214a16d494db0a",
    //         "03dcb84917cf6d7b742f58c04693c5e00c56a4ae83feec129b3e3cc27111796232",
    //         "02c3d1ae1b8fe831218f78cf09d864e60818ebdba4aacc74ecc2bcf2734aadf5ea",
    //         "0306950dae7158103814e3828b1ab97a87dbb3680db1b4c6998b8208865b2f9db7",
    //         "022eedf9f1cdae0cfaae635fe415b6a8f1912bc89bc3880ec41135d62cbbebd3d3",
    //         "02adfadcf8b9c8c1925c8662ac9cde0763c92b06404dfffad8555f41638cdf4780",
    //         "03ce92e54f9dbb5e4a050edddf5862dee29f419c60ceaad052d50aad6fcced5652",
    //         "03a8ff0a3cbdcb3bfbdb84dbf83226f338ba1452047ac5b8228a1513f7f1de80de",
    //         "02e311d97f92dc879860ec0d63b344239f17149ed1700b279b5ef52d2baaa0226f",
    //         "03eda1b9127d9a12a7c6903ca896534937ec492afa12ffa57a9aa6f3c77b618fdb",
    //         "03f6af8c750b9d29d9da3d4ddf5818a1fcdd4558ba0dde731f9c4b17bcbdcd83f2"
    //     ]
    // }
    // [2020-10-26 14:12:08.434] WARNING: {
    //     "round": 112166,
    //     "height": 5720467,
    //     "seedSource": "112166",
    //     "currentSeed": "2fc4a087ad1e561ad165973b61ab8d6e29df3becd6b3ca341e03baf506950da8"
    // }
    // [2020-10-26 14:12:08.438] WARNING: seed: 2fc4a087ad1e561ad165973b61ab8d6e29df3becd6b3ca341e03baf506950da8
    // [2020-10-26 14:12:08.447] WARNING: seed: 227e4fc752b161715ddbf838571d56101ab542b52648fc8d59e452615be56801
    // [2020-10-26 14:12:08.448] WARNING: seed: aeb502c7857e78bbde89dbe8d8bbf0275b57a4af528fa66cf57c4e5105d72dc7
    // [2020-10-26 14:12:08.448] WARNING: seed: 691a10ca9120e50a2bdf27478c4a2c6baa247acdfdf24661315a3c3f91d56be2
    // [2020-10-26 14:12:08.448] WARNING: seed: 330bf5130d2aaa35ba75a613d338f3e8b08f89948ee6a8f5b1326d7029db8ccb
    // [2020-10-26 14:12:08.449] WARNING: seed: 9bb77d6f29de8581bad156797683298bb9f3df1e594d8e541c03037b26a934a3
    // [2020-10-26 14:12:08.449] WARNING: seed: f429b7ef4a7fd90971a77ebe192ade005627312e12c7f562ae5b712008c03621
    // [2020-10-26 14:12:08.449] WARNING: seed: 11b17d13fa81cb0376a836d626ec3e56662c47df08d396b0a54743dbe266b7c8
    // [2020-10-26 14:12:08.449] WARNING: seed: d82dcb753503199e38df3d229db24ac1a585145e045db6693bf80017116e2b18
    // [2020-10-26 14:12:08.449] WARNING: seed: c33765b12c768b5936fa972169095c2206ce4fa5a04a07bc4e00c861216d70a8
    // [2020-10-26 14:12:08.450] WARNING: seed: f9bda56832cb0ee94238dc22b22eaaa4312f2da2125f5e24a295d7c61c3859ac
    // [2020-10-26 14:12:08.450] WARNING: {
    //     "method": "activeDelegatesPublicKeys",
    //     "result": {
    //         "height": 5720466,
    //         "timestamp": 113620312,
    //         "round": {
    //             "round": 112166,
    //             "roundHeight": 5720416,
    //             "nextRound": 112167,
    //             "maxDelegates": 51
    //         },
    //         "activeDelegatesPublicKeys": [
    //             "02e345079aca0567db96ec0ba3acf859b7cfd15134a855671f9c0fe8b1173767bd",
    //             "0306950dae7158103814e3828b1ab97a87dbb3680db1b4c6998b8208865b2f9db7",
    //             "024d5eacc5e05e1b05c476b367b7d072857826d9b271e07d3a3327224db8892a21",
    //             "0236d5232cdbd1e7ab87fad10ebe689c4557bc9d0c408b6773be964c837231d5f0",
    //             "0242555e90957de10e3912ce8831bcc985a40a645447dbfe8a0913ee6d89914707",
    //             "02257c58004e5ae23716d1c44beea0cca7f5b522a692df367bae9015a4f15c1670",
    //             "03380be01971b9f58131974234d466adca4889cb8e9616d64166980370e6bf1157",
    //             "02d0244d939fad9004cc104f71b46b428d903e4f2988a65f39fdaa1b7482894c9e",
    //             "03ce92e54f9dbb5e4a050edddf5862dee29f419c60ceaad052d50aad6fcced5652",
    //             "02ac8d84d81648154f79ba64fbf64cd6ee60f385b2aa52e8eb72bc1374bf55a68c",
    //             "0304d0c477d634cc85d89c1a4afee8f51168d1747fe8fd79cabc26565e49eb8a7a",
    //             "037850667ea2c8473adf7c87ee4496af1b7821f4e10761e78c3b391d6fcfbde9bb",
    //             "02789894f309f08a4e7833452552aa39e168005d893cafc8ef995edbfdba396d2c",
    //             "027716e659220085e41389efc7cf6a05f7f7c659cf3db9126caabce6cda9156582",
    //             "02677f73453da6073f5cf76db8f65fabc1a3b7aadc7b06027e0df709f14e097790",
    //             "0215789ac26155b7a338708f595b97c453e08918d0630c896cbd31d83fe2ad1c33",
    //             "03f3512aa9717b2ca83d371ed3bb2d3ff922969f3ceef92f65c060afa2bc2244fb",
    //             "029918d8fe6a78cc01bbab31f636494568dd954431f75f4ea6ff1da040b7063a70",
    //             "03eda1b9127d9a12a7c6903ca896534937ec492afa12ffa57a9aa6f3c77b618fdb",
    //             "0296893488d335ff818391da7c450cfeb7821a4eb535b15b95808ea733915fbfb1",
    //             "03a8ff0a3cbdcb3bfbdb84dbf83226f338ba1452047ac5b8228a1513f7f1de80de",
    //             "03d60e675b8a4b461361689e29fcf809cc4724de57ad7e7f73825e16d7b092d338",
    //             "03dcb84917cf6d7b742f58c04693c5e00c56a4ae83feec129b3e3cc27111796232",
    //             "02951227bb3bc5309aeb96460dbdf945746012810bb4020f35c20feae4eea7e5d4",
    //             "02e311d97f92dc879860ec0d63b344239f17149ed1700b279b5ef52d2baaa0226f",
    //             "032cfbb18f4e49952c6d6475e8adc6d0cba00b81ef6606cc4927b78c6c50558beb",
    //             "03b12f99375c3b0e4f5f5c7ea74e723f0b84a6f169b47d9105ed2a179f30c82df2",
    //             "023ee98f453661a1cb765fd60df95b4efb1e110660ffb88ae31c2368a70f1f7359",
    //             "0352e9ea81b7fb78b80ab6598e66d23764249c77b9492e3c1b0705d9d0722b729f",
    //             "023e3b421c730f85d2db546ee58f2b8d81dc141c3b12f8b8efadba8ddf085a4db6",
    //             "02cd9f56a176c843724eb58d3ef89dc88915a814bdcf284b02933e0dd203630a83",
    //             "0284a88da69cc04439633217c6961d2800df0f7dff7f85b9803848ee02d0743f1d",
    //             "03b906102928cf97c6ddeb59cefb0e1e02105a22ab1acc3b4906214a16d494db0a",
    //             "022ffb5fa4eb5b2e71c985b1d796642528802f04a6ddf9a449ba1aab292a9744aa",
    //             "035c14e8c5f0ee049268c3e75f02f05b4246e746dc42f99271ff164b7be20cf5b8",
    //             "02747353898e59c4f784542f357d5dd938a2872adb53abb94924091fddfdd83dc3",
    //             "03d3c6889608074b44155ad2e6577c3368e27e6e129c457418eb3e5ed029544e8d",
    //             "037997a6553ea8073eb199e9f5ff23b8f0892e79433ef35e13966e0a12849d02e3",
    //             "02d2f48a7ebb5b6d484de15b4cab8ab13c1d39b7141301efe048714aa9d82eb1cd",
    //             "0250b742256f9321bd7d46f3ed9769b215a7c2fb02be951acf43bc51eb57ceadf6",
    //             "02062f6f6d2aabafd745e6b01f4aa788a012c4ce7131312026bdb6eb4e74a464d2",
    //             "02adfadcf8b9c8c1925c8662ac9cde0763c92b06404dfffad8555f41638cdf4780",
    //             "025341ecfcbb48f9ecac8b87d6e5ace9fb172cee9c521a036f20861f515077bfc3",
    //             "031a6d8dab63668e901661c592dfe4bcc75793959d6ee6300408482840487d1faf",
    //             "022eedf9f1cdae0cfaae635fe415b6a8f1912bc89bc3880ec41135d62cbbebd3d3",
    //             "033a5474f68f92f254691e93c06a2f22efaf7d66b543a53efcece021819653a200",
    //             "03ccf15ff3a07e1a4b04692f7f2db3a06948708dacfff47661c259f2fa689e1941",
    //             "02c3d1ae1b8fe831218f78cf09d864e60818ebdba4aacc74ecc2bcf2734aadf5ea",
    //             "03153c994e5306b2fbba9bb533f22871e12e4c1d1d3960d1eeef385ab143b258b4",
    //             "039b5a3a71335bfa6c72b82498f814123e0678f7cd3d8e7221ec7124918736e01c",
    //             "03f6af8c750b9d29d9da3d4ddf5818a1fcdd4558ba0dde731f9c4b17bcbdcd83f2"
    //         ]
    //     }
    // }

    public static function execute(Collection $delegates): array
    {
        // Arrange Block
        $lastBlock = Block::current();
        $height    = 5720466; // $lastBlock->height->toNumber();
        $timestamp = 113620312; // $lastBlock->timestamp;

        // Arrange Delegates
        $activeDelegates = $delegates->toBase()->map(fn ($delegate) => $delegate->public_key);

        dump([
            'INPUT_EQUAL' => $activeDelegates->toArray() === static::EXPECTED['input'],
            'INPUT_DIFFS' => array_diff($activeDelegates->toArray(), static::EXPECTED['input']),
        ]);

        $activeDelegates = static::getActiveDelegates($activeDelegates->toArray(), $height);

        dd([
            'OUTPUT_EQUAL' => $activeDelegates === static::EXPECTED['output'],
            'OUTPUT_DIFFS' => array_diff($activeDelegates, static::EXPECTED['output']),
        ]);

        // Arrange Constants
        $maxDelegates = Network::delegateCount();
        $blockTime    = Network::blockTime();

        // Act
        $forgingInfo = ForgingInfoCalculator::calculateForgingInfo($timestamp, $height);

        // Determine Next Forgers...
        $nextForgers = [];
        for ($i = 0; $i < $maxDelegates; $i++) {
            $delegate = $activeDelegates[($forgingInfo['currentForger'] + $i) % $maxDelegates];

            if ($delegate) {
                $nextForgers[] = $delegate;
            }
        }

        if (count($activeDelegates) < $maxDelegates) {
            return [];
        }

        // Map Next Forgers...
        $result = [
            // 'delegates'     => [],
            // 'nextRoundTime' => ($maxDelegates - $forgingInfo['currentForger'] - 1) * $blockTime,
        ];

        foreach ($delegates as $delegate) {
            $indexInNextForgers = 0;

            for ($i = 0; $i < count($nextForgers); $i++) {
                if ($nextForgers[$i] === $delegate->public_key) {
                    $indexInNextForgers = $i;

                    break;
                }
            }

            if ($indexInNextForgers === 0) {
                $result[$indexInNextForgers] = [
                    'publicKey' => $delegate->public_key,
                    'status'    => 'next',
                    'time'      => 0,
                    'order'     => $indexInNextForgers,
                ];
            } elseif ($indexInNextForgers <= $maxDelegates - $forgingInfo['nextForger']) {
                $result[$indexInNextForgers] = [
                    'publicKey' => $delegate->public_key,
                    'status'    => 'pending',
                    'time'      => $indexInNextForgers * $blockTime * 1000,
                    'order'     => $indexInNextForgers,
                ];
            } else {
                $result[$indexInNextForgers] = [
                    'publicKey' => $delegate->public_key,
                    'status'    => 'done',
                    'time'      => 0,
                    'order'     => $indexInNextForgers,
                ];
            }
        }

        return collect($result)->sortBy('order')->toArray();
    }

    private static function getActiveDelegates(array $delegates, int $height): array
    {
        $seedSource  = (string) RoundCalculator::calculate($height)['round'];
        $currentSeed = hex2bin(hash('sha256', $seedSource));
        $delCount    = count($delegates);

        $seeds = [];
        for ($i = 0; $i < $delCount; $i++) {
            for ($x = 0; $x < 4 && $i < $delCount; $i++, $x++) {
                $newIndex             = intval($currentSeed[$x]) % $delCount;
                $b                    = $delegates[$newIndex];
                $delegates[$newIndex] = $delegates[$i];
                $delegates[$i]        = $b;
            }

            $seeds[] = bin2hex($currentSeed);

            $currentSeed = hex2bin(hash('sha256', $currentSeed));
        }

        dump([
            'SEEDS_EQUAL' => $seeds === static::EXPECTED['seeds'],
            'SEEDS_DIFFS' => array_diff($seeds, static::EXPECTED['seeds']),
        ]);

        return $delegates;
    }
}
