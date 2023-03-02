<?php











namespace Composer;

use Composer\Autoload\ClassLoader;
use Composer\Semver\VersionParser;






class InstalledVersions
{
private static $installed = array (
  'root' => 
  array (
    'pretty_version' => 'dev-master',
    'version' => 'dev-master',
    'aliases' => 
    array (
    ),
    'reference' => 'e58d50284b7ba4bc766d68fb214b687470200edf',
    'name' => 'laravel/laravel',
  ),
  'versions' => 
  array (
    'asm89/stack-cors' => 
    array (
      'pretty_version' => '1.3.0',
      'version' => '1.3.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b9c31def6a83f84b4d4a40d35996d375755f0e08',
    ),
    'barryvdh/laravel-debugbar' => 
    array (
      'pretty_version' => 'v3.7.0',
      'version' => '3.7.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '3372ed65e6d2039d663ed19aa699956f9d346271',
    ),
    'brick/math' => 
    array (
      'pretty_version' => '0.9.3',
      'version' => '0.9.3.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ca57d18f028f84f777b2168cd1911b0dee2343ae',
    ),
    'composer/semver' => 
    array (
      'pretty_version' => '3.3.2',
      'version' => '3.3.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '3953f23262f2bff1919fc82183ad9acb13ff62c9',
    ),
    'cordoval/hamcrest-php' => 
    array (
      'replaced' => 
      array (
        0 => '*',
      ),
    ),
    'davedevelopment/hamcrest-php' => 
    array (
      'replaced' => 
      array (
        0 => '*',
      ),
    ),
    'defuse/php-encryption' => 
    array (
      'pretty_version' => 'v2.3.1',
      'version' => '2.3.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '77880488b9954b7884c25555c2a0ea9e7053f9d2',
    ),
    'doctrine/annotations' => 
    array (
      'pretty_version' => '1.14.3',
      'version' => '1.14.3.0',
      'aliases' => 
      array (
      ),
      'reference' => 'fb0d71a7393298a7b232cbf4c8b1f73f3ec3d5af',
    ),
    'doctrine/cache' => 
    array (
      'pretty_version' => '1.13.0',
      'version' => '1.13.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '56cd022adb5514472cb144c087393c1821911d09',
    ),
    'doctrine/collections' => 
    array (
      'pretty_version' => '1.8.0',
      'version' => '1.8.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '2b44dd4cbca8b5744327de78bafef5945c7e7b5e',
    ),
    'doctrine/common' => 
    array (
      'pretty_version' => 'v2.7.3',
      'version' => '2.7.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '4acb8f89626baafede6ee5475bc5844096eba8a9',
    ),
    'doctrine/dbal' => 
    array (
      'pretty_version' => 'v2.5.13',
      'version' => '2.5.13.0',
      'aliases' => 
      array (
      ),
      'reference' => '729340d8d1eec8f01bff708e12e449a3415af873',
    ),
    'doctrine/deprecations' => 
    array (
      'pretty_version' => 'v1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '0e2a4f1f8cdfc7a92ec3b01c9334898c806b30de',
    ),
    'doctrine/inflector' => 
    array (
      'pretty_version' => '1.4.4',
      'version' => '1.4.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '4bd5c1cdfcd00e9e2d8c484f79150f67e5d355d9',
    ),
    'doctrine/instantiator' => 
    array (
      'pretty_version' => '1.5.0',
      'version' => '1.5.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '0a0fa9780f5d4e507415a065172d26a98d02047b',
    ),
    'doctrine/lexer' => 
    array (
      'pretty_version' => '1.2.3',
      'version' => '1.2.3.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c268e882d4dbdd85e36e4ad69e02dc284f89d229',
    ),
    'dragonmantank/cron-expression' => 
    array (
      'pretty_version' => 'v2.3.1',
      'version' => '2.3.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '65b2d8ee1f10915efb3b55597da3404f096acba2',
    ),
    'egulias/email-validator' => 
    array (
      'pretty_version' => '2.1.25',
      'version' => '2.1.25.0',
      'aliases' => 
      array (
      ),
      'reference' => '0dbf5d78455d4d6a41d186da50adc1122ec066f4',
    ),
    'ezyang/htmlpurifier' => 
    array (
      'pretty_version' => 'v4.16.0',
      'version' => '4.16.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '523407fb06eb9e5f3d59889b3978d5bfe94299c8',
    ),
    'facade/flare-client-php' => 
    array (
      'pretty_version' => '1.10.0',
      'version' => '1.10.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '213fa2c69e120bca4c51ba3e82ed1834ef3f41b8',
    ),
    'facade/ignition' => 
    array (
      'pretty_version' => '2.17.7',
      'version' => '2.17.7.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b4f5955825bb4b74cba0f94001761c46335c33e9',
    ),
    'facade/ignition-contracts' => 
    array (
      'pretty_version' => '1.0.2',
      'version' => '1.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '3c921a1cdba35b68a7f0ccffc6dffc1995b18267',
    ),
    'fideloper/proxy' => 
    array (
      'pretty_version' => '4.4.2',
      'version' => '4.4.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a751f2bc86dd8e6cfef12dc0cbdada82f5a18750',
    ),
    'filp/whoops' => 
    array (
      'pretty_version' => '2.14.6',
      'version' => '2.14.6.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f7948baaa0330277c729714910336383286305da',
    ),
    'firebase/php-jwt' => 
    array (
      'pretty_version' => 'v5.5.1',
      'version' => '5.5.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '83b609028194aa042ea33b5af2d41a7427de80e6',
    ),
    'fruitcake/laravel-cors' => 
    array (
      'pretty_version' => 'v1.0.6',
      'version' => '1.0.6.0',
      'aliases' => 
      array (
      ),
      'reference' => '1d127dbec313e2e227d65e0c483765d8d7559bf6',
    ),
    'fzaninotto/faker' => 
    array (
      'pretty_version' => 'v1.9.2',
      'version' => '1.9.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '848d8125239d7dbf8ab25cb7f054f1a630e68c2e',
    ),
    'guzzlehttp/guzzle' => 
    array (
      'pretty_version' => '7.5.0',
      'version' => '7.5.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b50a2a1251152e43f6a37f0fa053e730a67d25ba',
    ),
    'guzzlehttp/promises' => 
    array (
      'pretty_version' => '1.5.2',
      'version' => '1.5.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b94b2807d85443f9719887892882d0329d1e2598',
    ),
    'guzzlehttp/psr7' => 
    array (
      'pretty_version' => '2.4.3',
      'version' => '2.4.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '67c26b443f348a51926030c83481b85718457d3d',
    ),
    'hamcrest/hamcrest-php' => 
    array (
      'pretty_version' => 'v2.0.1',
      'version' => '2.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '8c3d0a3f6af734494ad8f6fbbee0ba92422859f3',
    ),
    'illuminate/auth' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/broadcasting' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/bus' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/cache' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/config' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/console' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/container' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/contracts' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/cookie' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/database' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/encryption' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/events' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/filesystem' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/hashing' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/http' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/log' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/mail' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/notifications' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/pagination' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/pipeline' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/queue' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/redis' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/routing' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/session' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/support' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/testing' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/translation' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/validation' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'illuminate/view' => 
    array (
      'replaced' => 
      array (
        0 => 'v7.30.6',
      ),
    ),
    'kodova/hamcrest-php' => 
    array (
      'replaced' => 
      array (
        0 => '*',
      ),
    ),
    'laminas/laminas-diactoros' => 
    array (
      'pretty_version' => '2.14.0',
      'version' => '2.14.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '6cb35f61913f06b2c91075db00f67cfd78869e28',
    ),
    'laravel/framework' => 
    array (
      'pretty_version' => 'v7.30.6',
      'version' => '7.30.6.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ecdafad1dda3c790af186a6d18479ea4757ef9ee',
    ),
    'laravel/laravel' => 
    array (
      'pretty_version' => 'dev-master',
      'version' => 'dev-master',
      'aliases' => 
      array (
      ),
      'reference' => 'e58d50284b7ba4bc766d68fb214b687470200edf',
    ),
    'laravel/passport' => 
    array (
      'pretty_version' => 'v9.4.0',
      'version' => '9.4.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '011bd500e8ae3d459b692467880a49ff1ecd60c0',
    ),
    'laravel/tinker' => 
    array (
      'pretty_version' => 'v2.8.1',
      'version' => '2.8.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '04a2d3bd0d650c0764f70bf49d1ee39393e4eb10',
    ),
    'laravel/ui' => 
    array (
      'pretty_version' => 'v2.5.0',
      'version' => '2.5.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd01a705763c243b07be795e9d1bb47f89260f73d',
    ),
    'laravelcollective/html' => 
    array (
      'pretty_version' => 'v6.4.0',
      'version' => '6.4.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ac74f580459a5120079b8def0404e5d312a09504',
    ),
    'lcobucci/jwt' => 
    array (
      'pretty_version' => '3.4.6',
      'version' => '3.4.6.0',
      'aliases' => 
      array (
      ),
      'reference' => '3ef8657a78278dfeae7707d51747251db4176240',
    ),
    'league/commonmark' => 
    array (
      'pretty_version' => '1.6.7',
      'version' => '1.6.7.0',
      'aliases' => 
      array (
      ),
      'reference' => '2b8185c13bc9578367a5bf901881d1c1b5bbd09b',
    ),
    'league/event' => 
    array (
      'pretty_version' => '2.2.0',
      'version' => '2.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd2cc124cf9a3fab2bb4ff963307f60361ce4d119',
    ),
    'league/flysystem' => 
    array (
      'pretty_version' => '1.1.10',
      'version' => '1.1.10.0',
      'aliases' => 
      array (
      ),
      'reference' => '3239285c825c152bcc315fe0e87d6b55f5972ed1',
    ),
    'league/mime-type-detection' => 
    array (
      'pretty_version' => '1.11.0',
      'version' => '1.11.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ff6248ea87a9f116e78edd6002e39e5128a0d4dd',
    ),
    'league/oauth2-server' => 
    array (
      'pretty_version' => '8.4.0',
      'version' => '8.4.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '539f4340c14eca8d44578fd118f6bdc0ad16d1ce',
    ),
    'league/oauth2server' => 
    array (
      'replaced' => 
      array (
        0 => '*',
      ),
    ),
    'league/uri' => 
    array (
      'pretty_version' => '6.5.0',
      'version' => '6.5.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c68ca445abb04817d740ddd6d0b3551826ef0c5a',
    ),
    'league/uri-interfaces' => 
    array (
      'pretty_version' => '2.3.0',
      'version' => '2.3.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '00e7e2943f76d8cb50c7dfdc2f6dee356e15e383',
    ),
    'lncd/oauth2' => 
    array (
      'replaced' => 
      array (
        0 => '*',
      ),
    ),
    'maatwebsite/excel' => 
    array (
      'pretty_version' => '3.1.48',
      'version' => '3.1.48.0',
      'aliases' => 
      array (
      ),
      'reference' => '6d0fe2a1d195960c7af7bf0de760582da02a34b9',
    ),
    'maennchen/zipstream-php' => 
    array (
      'pretty_version' => '2.1.0',
      'version' => '2.1.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c4c5803cc1f93df3d2448478ef79394a5981cc58',
    ),
    'markbaker/complex' => 
    array (
      'pretty_version' => '3.0.2',
      'version' => '3.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '95c56caa1cf5c766ad6d65b6344b807c1e8405b9',
    ),
    'markbaker/matrix' => 
    array (
      'pretty_version' => '3.0.1',
      'version' => '3.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '728434227fe21be27ff6d86621a1b13107a2562c',
    ),
    'maximebf/debugbar' => 
    array (
      'pretty_version' => 'v1.18.2',
      'version' => '1.18.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '17dcf3f6ed112bb85a37cf13538fd8de49f5c274',
    ),
    'mockery/mockery' => 
    array (
      'pretty_version' => '1.5.1',
      'version' => '1.5.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e92dcc83d5a51851baf5f5591d32cb2b16e3684e',
    ),
    'monolog/monolog' => 
    array (
      'pretty_version' => '2.9.1',
      'version' => '2.9.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f259e2b15fb95494c83f52d3caad003bbf5ffaa1',
    ),
    'myclabs/deep-copy' => 
    array (
      'pretty_version' => '1.10.2',
      'version' => '1.10.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '776f831124e9c62e1a2c601ecc52e776d8bb7220',
      'replaced' => 
      array (
        0 => '1.10.2',
      ),
    ),
    'myclabs/php-enum' => 
    array (
      'pretty_version' => '1.8.4',
      'version' => '1.8.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a867478eae49c9f59ece437ae7f9506bfaa27483',
    ),
    'nesbot/carbon' => 
    array (
      'pretty_version' => '2.66.0',
      'version' => '2.66.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '496712849902241f04902033b0441b269effe001',
    ),
    'nikic/php-parser' => 
    array (
      'pretty_version' => 'v4.15.3',
      'version' => '4.15.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '570e980a201d8ed0236b0a62ddf2c9cbb2034039',
    ),
    'nunomaduro/collision' => 
    array (
      'pretty_version' => 'v4.3.0',
      'version' => '4.3.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '7c125dc2463f3e144ddc7e05e63077109508c94e',
    ),
    'nxp/math-executor' => 
    array (
      'pretty_version' => 'V2.1.11',
      'version' => '2.1.11.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a0ff7a79af8c3bc5e9c5decee24cbefb5d80e93b',
    ),
    'nyholm/psr7' => 
    array (
      'pretty_version' => '1.5.1',
      'version' => '1.5.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f734364e38a876a23be4d906a2a089e1315be18a',
    ),
    'opis/closure' => 
    array (
      'pretty_version' => '3.6.3',
      'version' => '3.6.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '3d81e4309d2a927abbe66df935f4bb60082805ad',
    ),
    'paragonie/random_compat' => 
    array (
      'pretty_version' => 'v9.99.100',
      'version' => '9.99.100.0',
      'aliases' => 
      array (
      ),
      'reference' => '996434e5492cb4c3edcb9168db6fbb1359ef965a',
    ),
    'phar-io/manifest' => 
    array (
      'pretty_version' => '2.0.3',
      'version' => '2.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '97803eca37d319dfa7826cc2437fc020857acb53',
    ),
    'phar-io/version' => 
    array (
      'pretty_version' => '3.2.1',
      'version' => '3.2.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '4f7fd7836c6f332bb2933569e566a0d6c4cbed74',
    ),
    'php-http/message-factory' => 
    array (
      'pretty_version' => 'v1.0.2',
      'version' => '1.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a478cb11f66a6ac48d8954216cfed9aa06a501a1',
    ),
    'phpoffice/phpspreadsheet' => 
    array (
      'pretty_version' => '1.25.2',
      'version' => '1.25.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a317a09e7def49852400a4b3eca4a4b0790ceeb5',
    ),
    'phpoption/phpoption' => 
    array (
      'pretty_version' => '1.9.1',
      'version' => '1.9.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'dd3a383e599f49777d8b628dadbb90cae435b87e',
    ),
    'phpseclib/phpseclib' => 
    array (
      'pretty_version' => '2.0.41',
      'version' => '2.0.41.0',
      'aliases' => 
      array (
      ),
      'reference' => '7e763c6f97ec1fcb37c46aa8ecfc20a2c71d9c1b',
    ),
    'phpunit/php-code-coverage' => 
    array (
      'pretty_version' => '7.0.15',
      'version' => '7.0.15.0',
      'aliases' => 
      array (
      ),
      'reference' => '819f92bba8b001d4363065928088de22f25a3a48',
    ),
    'phpunit/php-file-iterator' => 
    array (
      'pretty_version' => '2.0.5',
      'version' => '2.0.5.0',
      'aliases' => 
      array (
      ),
      'reference' => '42c5ba5220e6904cbfe8b1a1bda7c0cfdc8c12f5',
    ),
    'phpunit/php-text-template' => 
    array (
      'pretty_version' => '1.2.1',
      'version' => '1.2.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '31f8b717e51d9a2afca6c9f046f5d69fc27c8686',
    ),
    'phpunit/php-timer' => 
    array (
      'pretty_version' => '2.1.3',
      'version' => '2.1.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '2454ae1765516d20c4ffe103d85a58a9a3bd5662',
    ),
    'phpunit/php-token-stream' => 
    array (
      'pretty_version' => '4.0.4',
      'version' => '4.0.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a853a0e183b9db7eed023d7933a858fa1c8d25a3',
    ),
    'phpunit/phpunit' => 
    array (
      'pretty_version' => '8.5.33',
      'version' => '8.5.33.0',
      'aliases' => 
      array (
      ),
      'reference' => '7d1ff0e8c6b35db78ff13e3e05517d7cbf7aa32e',
    ),
    'psr/cache' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd11b50ad223250cf17b86e38383413f5a6764bf8',
    ),
    'psr/container' => 
    array (
      'pretty_version' => '1.1.1',
      'version' => '1.1.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '8622567409010282b7aeebe4bb841fe98b58dcaf',
    ),
    'psr/container-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/event-dispatcher' => 
    array (
      'pretty_version' => '1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'dbefd12671e8a14ec7f180cab83036ed26714bb0',
    ),
    'psr/event-dispatcher-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/http-client' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '2dfb5f6c5eff0e91e20e913f8c5452ed95b86621',
    ),
    'psr/http-client-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/http-factory' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '12ac7fcd07e5b077433f5f2bee95b3a771bf61be',
    ),
    'psr/http-factory-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/http-message' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f6561bf28d520154e4b0ec72be95418abe6d9363',
    ),
    'psr/http-message-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/log' => 
    array (
      'pretty_version' => '1.1.4',
      'version' => '1.1.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd49695b909c3b7628b6289db5479a1c204601f11',
    ),
    'psr/log-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
        1 => '1.0|2.0',
        2 => '1.0.0 || 2.0.0 || 3.0.0',
      ),
    ),
    'psr/simple-cache' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '408d5eafb83c57f6365a3ca330ff23aa4a5fa39b',
    ),
    'psy/psysh' => 
    array (
      'pretty_version' => 'v0.11.12',
      'version' => '0.11.12.0',
      'aliases' => 
      array (
      ),
      'reference' => '52cb7c47d403c31c0adc9bf7710fc355f93c20f7',
    ),
    'ralouphie/getallheaders' => 
    array (
      'pretty_version' => '3.0.3',
      'version' => '3.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '120b605dfeb996808c31b6477290a714d356e822',
    ),
    'ramsey/collection' => 
    array (
      'pretty_version' => '1.2.2',
      'version' => '1.2.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'cccc74ee5e328031b15640b51056ee8d3bb66c0a',
    ),
    'ramsey/uuid' => 
    array (
      'pretty_version' => '4.2.3',
      'version' => '4.2.3.0',
      'aliases' => 
      array (
      ),
      'reference' => 'fc9bb7fb5388691fd7373cd44dcb4d63bbcf24df',
    ),
    'rhumsaa/uuid' => 
    array (
      'replaced' => 
      array (
        0 => '4.2.3',
      ),
    ),
    'sebastian/code-unit-reverse-lookup' => 
    array (
      'pretty_version' => '1.0.2',
      'version' => '1.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '1de8cd5c010cb153fcd68b8d0f64606f523f7619',
    ),
    'sebastian/comparator' => 
    array (
      'pretty_version' => '3.0.5',
      'version' => '3.0.5.0',
      'aliases' => 
      array (
      ),
      'reference' => '1dc7ceb4a24aede938c7af2a9ed1de09609ca770',
    ),
    'sebastian/diff' => 
    array (
      'pretty_version' => '3.0.3',
      'version' => '3.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '14f72dd46eaf2f2293cbe79c93cc0bc43161a211',
    ),
    'sebastian/environment' => 
    array (
      'pretty_version' => '4.2.4',
      'version' => '4.2.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd47bbbad83711771f167c72d4e3f25f7fcc1f8b0',
    ),
    'sebastian/exporter' => 
    array (
      'pretty_version' => '3.1.5',
      'version' => '3.1.5.0',
      'aliases' => 
      array (
      ),
      'reference' => '73a9676f2833b9a7c36968f9d882589cd75511e6',
    ),
    'sebastian/global-state' => 
    array (
      'pretty_version' => '3.0.2',
      'version' => '3.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'de036ec91d55d2a9e0db2ba975b512cdb1c23921',
    ),
    'sebastian/object-enumerator' => 
    array (
      'pretty_version' => '3.0.4',
      'version' => '3.0.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e67f6d32ebd0c749cf9d1dbd9f226c727043cdf2',
    ),
    'sebastian/object-reflector' => 
    array (
      'pretty_version' => '1.1.2',
      'version' => '1.1.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '9b8772b9cbd456ab45d4a598d2dd1a1bced6363d',
    ),
    'sebastian/recursion-context' => 
    array (
      'pretty_version' => '3.0.1',
      'version' => '3.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '367dcba38d6e1977be014dc4b22f47a484dac7fb',
    ),
    'sebastian/resource-operations' => 
    array (
      'pretty_version' => '2.0.2',
      'version' => '2.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '31d35ca87926450c44eae7e2611d45a7a65ea8b3',
    ),
    'sebastian/type' => 
    array (
      'pretty_version' => '1.1.4',
      'version' => '1.1.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '0150cfbc4495ed2df3872fb31b26781e4e077eb4',
    ),
    'sebastian/version' => 
    array (
      'pretty_version' => '2.0.1',
      'version' => '2.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '99732be0ddb3361e16ad77b68ba41efc8e979019',
    ),
    'spatie/db-dumper' => 
    array (
      'pretty_version' => '2.21.1',
      'version' => '2.21.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '05e5955fb882008a8947c5a45146d86cfafa10d1',
    ),
    'spatie/laravel-backup' => 
    array (
      'pretty_version' => '6.16.5',
      'version' => '6.16.5.0',
      'aliases' => 
      array (
      ),
      'reference' => '332fae80b12cacb9e4161824ba195d984b28c8fb',
    ),
    'spatie/laravel-permission' => 
    array (
      'pretty_version' => '3.18.0',
      'version' => '3.18.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '1c51a5fa12131565fe3860705163e53d7a26258a',
    ),
    'spatie/temporary-directory' => 
    array (
      'pretty_version' => '1.3.0',
      'version' => '1.3.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f517729b3793bca58f847c5fd383ec16f03ffec6',
    ),
    'swiftmailer/swiftmailer' => 
    array (
      'pretty_version' => 'v6.3.0',
      'version' => '6.3.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '8a5d5072dca8f48460fce2f4131fcc495eec654c',
    ),
    'symfony/console' => 
    array (
      'pretty_version' => 'v5.4.21',
      'version' => '5.4.21.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c77433ddc6cdc689caf48065d9ea22ca0853fbd9',
    ),
    'symfony/css-selector' => 
    array (
      'pretty_version' => 'v5.4.21',
      'version' => '5.4.21.0',
      'aliases' => 
      array (
      ),
      'reference' => '95f3c7468db1da8cc360b24fa2a26e7cefcb355d',
    ),
    'symfony/deprecation-contracts' => 
    array (
      'pretty_version' => 'v2.5.2',
      'version' => '2.5.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e8b495ea28c1d97b5e0c121748d6f9b53d075c66',
    ),
    'symfony/error-handler' => 
    array (
      'pretty_version' => 'v5.4.21',
      'version' => '5.4.21.0',
      'aliases' => 
      array (
      ),
      'reference' => '56a94aa8cb5a5fbc411551d8d014a296b5456549',
    ),
    'symfony/event-dispatcher' => 
    array (
      'pretty_version' => 'v5.4.21',
      'version' => '5.4.21.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f0ae1383a8285dfc6752b8d8602790953118ff5a',
    ),
    'symfony/event-dispatcher-contracts' => 
    array (
      'pretty_version' => 'v2.5.2',
      'version' => '2.5.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f98b54df6ad059855739db6fcbc2d36995283fe1',
    ),
    'symfony/event-dispatcher-implementation' => 
    array (
      'provided' => 
      array (
        0 => '2.0',
      ),
    ),
    'symfony/finder' => 
    array (
      'pretty_version' => 'v5.4.21',
      'version' => '5.4.21.0',
      'aliases' => 
      array (
      ),
      'reference' => '078e9a5e1871fcfe6a5ce421b539344c21afef19',
    ),
    'symfony/http-foundation' => 
    array (
      'pretty_version' => 'v5.4.21',
      'version' => '5.4.21.0',
      'aliases' => 
      array (
      ),
      'reference' => '3bb6ee5582366c4176d5ce596b380117c8200bbf',
    ),
    'symfony/http-kernel' => 
    array (
      'pretty_version' => 'v5.1.5',
      'version' => '5.1.5.0',
      'aliases' => 
      array (
      ),
      'reference' => '3e32676e6cb5d2081c91a56783471ff8a7f7110b',
    ),
    'symfony/mime' => 
    array (
      'pretty_version' => 'v5.4.21',
      'version' => '5.4.21.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ef57d9fb9cdd5e6b2ffc567d109865d10b6920cd',
    ),
    'symfony/polyfill-ctype' => 
    array (
      'pretty_version' => 'v1.27.0',
      'version' => '1.27.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '5bbc823adecdae860bb64756d639ecfec17b050a',
    ),
    'symfony/polyfill-iconv' => 
    array (
      'pretty_version' => 'v1.27.0',
      'version' => '1.27.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '927013f3aac555983a5059aada98e1907d842695',
    ),
    'symfony/polyfill-intl-grapheme' => 
    array (
      'pretty_version' => 'v1.27.0',
      'version' => '1.27.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '511a08c03c1960e08a883f4cffcacd219b758354',
    ),
    'symfony/polyfill-intl-idn' => 
    array (
      'pretty_version' => 'v1.27.0',
      'version' => '1.27.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '639084e360537a19f9ee352433b84ce831f3d2da',
    ),
    'symfony/polyfill-intl-normalizer' => 
    array (
      'pretty_version' => 'v1.27.0',
      'version' => '1.27.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '19bd1e4fcd5b91116f14d8533c57831ed00571b6',
    ),
    'symfony/polyfill-mbstring' => 
    array (
      'pretty_version' => 'v1.27.0',
      'version' => '1.27.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '8ad114f6b39e2c98a8b0e3bd907732c207c2b534',
    ),
    'symfony/polyfill-php72' => 
    array (
      'pretty_version' => 'v1.27.0',
      'version' => '1.27.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '869329b1e9894268a8a61dabb69153029b7a8c97',
    ),
    'symfony/polyfill-php73' => 
    array (
      'pretty_version' => 'v1.27.0',
      'version' => '1.27.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '9e8ecb5f92152187c4799efd3c96b78ccab18ff9',
    ),
    'symfony/polyfill-php80' => 
    array (
      'pretty_version' => 'v1.27.0',
      'version' => '1.27.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '7a6ff3f1959bb01aefccb463a0f2cd3d3d2fd936',
    ),
    'symfony/polyfill-php81' => 
    array (
      'pretty_version' => 'v1.27.0',
      'version' => '1.27.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '707403074c8ea6e2edaf8794b0157a0bfa52157a',
    ),
    'symfony/process' => 
    array (
      'pretty_version' => 'v5.4.21',
      'version' => '5.4.21.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd4ce417ebcb0b7d090b4c178ed6d3accc518e8bd',
    ),
    'symfony/psr-http-message-bridge' => 
    array (
      'pretty_version' => 'v2.1.4',
      'version' => '2.1.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a125b93ef378c492e274f217874906fb9babdebb',
    ),
    'symfony/routing' => 
    array (
      'pretty_version' => 'v5.4.21',
      'version' => '5.4.21.0',
      'aliases' => 
      array (
      ),
      'reference' => '2ea0f3049076e8ef96eab203a809d6b2332f0361',
    ),
    'symfony/service-contracts' => 
    array (
      'pretty_version' => 'v2.5.2',
      'version' => '2.5.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '4b426aac47d6427cc1a1d0f7e2ac724627f5966c',
    ),
    'symfony/string' => 
    array (
      'pretty_version' => 'v5.4.21',
      'version' => '5.4.21.0',
      'aliases' => 
      array (
      ),
      'reference' => 'edac10d167b78b1d90f46a80320d632de0bd9f2f',
    ),
    'symfony/translation' => 
    array (
      'pretty_version' => 'v5.4.21',
      'version' => '5.4.21.0',
      'aliases' => 
      array (
      ),
      'reference' => '6996affeea65705086939894b77110e9a7f80874',
    ),
    'symfony/translation-contracts' => 
    array (
      'pretty_version' => 'v2.5.2',
      'version' => '2.5.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '136b19dd05cdf0709db6537d058bcab6dd6e2dbe',
    ),
    'symfony/translation-implementation' => 
    array (
      'provided' => 
      array (
        0 => '2.3',
      ),
    ),
    'symfony/var-dumper' => 
    array (
      'pretty_version' => 'v5.4.21',
      'version' => '5.4.21.0',
      'aliases' => 
      array (
      ),
      'reference' => '6c5ac3a1be8b849d59a1a77877ee110e1b55eb74',
    ),
    'theseer/tokenizer' => 
    array (
      'pretty_version' => '1.2.1',
      'version' => '1.2.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '34a41e998c2183e22995f158c581e7b5e755ab9e',
    ),
    'tijsverkoyen/css-to-inline-styles' => 
    array (
      'pretty_version' => '2.2.6',
      'version' => '2.2.6.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c42125b83a4fa63b187fdf29f9c93cb7733da30c',
    ),
    'vlucas/phpdotenv' => 
    array (
      'pretty_version' => 'v4.3.0',
      'version' => '4.3.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '67a491df68208bef8c37092db11fa3885008efcf',
    ),
    'voku/portable-ascii' => 
    array (
      'pretty_version' => '1.6.1',
      'version' => '1.6.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '87337c91b9dfacee02452244ee14ab3c43bc485a',
    ),
    'yajra/laravel-datatables-oracle' => 
    array (
      'pretty_version' => 'v9.21.2',
      'version' => '9.21.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a7fd01f06282923e9c63fa27fe6b391e21dc321a',
    ),
  ),
);
private static $canGetVendors;
private static $installedByVendor = array();







public static function getInstalledPackages()
{
$packages = array();
foreach (self::getInstalled() as $installed) {
$packages[] = array_keys($installed['versions']);
}


if (1 === \count($packages)) {
return $packages[0];
}

return array_keys(array_flip(\call_user_func_array('array_merge', $packages)));
}









public static function isInstalled($packageName)
{
foreach (self::getInstalled() as $installed) {
if (isset($installed['versions'][$packageName])) {
return true;
}
}

return false;
}














public static function satisfies(VersionParser $parser, $packageName, $constraint)
{
$constraint = $parser->parseConstraints($constraint);
$provided = $parser->parseConstraints(self::getVersionRanges($packageName));

return $provided->matches($constraint);
}










public static function getVersionRanges($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

$ranges = array();
if (isset($installed['versions'][$packageName]['pretty_version'])) {
$ranges[] = $installed['versions'][$packageName]['pretty_version'];
}
if (array_key_exists('aliases', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['aliases']);
}
if (array_key_exists('replaced', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['replaced']);
}
if (array_key_exists('provided', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['provided']);
}

return implode(' || ', $ranges);
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['version'])) {
return null;
}

return $installed['versions'][$packageName]['version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getPrettyVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['pretty_version'])) {
return null;
}

return $installed['versions'][$packageName]['pretty_version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getReference($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['reference'])) {
return null;
}

return $installed['versions'][$packageName]['reference'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getRootPackage()
{
$installed = self::getInstalled();

return $installed[0]['root'];
}







public static function getRawData()
{
return self::$installed;
}



















public static function reload($data)
{
self::$installed = $data;
self::$installedByVendor = array();
}




private static function getInstalled()
{
if (null === self::$canGetVendors) {
self::$canGetVendors = method_exists('Composer\Autoload\ClassLoader', 'getRegisteredLoaders');
}

$installed = array();

if (self::$canGetVendors) {
foreach (ClassLoader::getRegisteredLoaders() as $vendorDir => $loader) {
if (isset(self::$installedByVendor[$vendorDir])) {
$installed[] = self::$installedByVendor[$vendorDir];
} elseif (is_file($vendorDir.'/composer/installed.php')) {
$installed[] = self::$installedByVendor[$vendorDir] = require $vendorDir.'/composer/installed.php';
}
}
}

$installed[] = self::$installed;

return $installed;
}
}
