<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2ef8b491792689d39ce5599da3ed681a
{
    public static $files = array (
        'e40631d46120a9c38ea139981f8dab26' => __DIR__ . '/..' . '/ircmaxell/password-compat/lib/password.php',
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        'edc6464955a37aa4d5fbf39d40fb6ee7' => __DIR__ . '/..' . '/symfony/polyfill-php55/bootstrap.php',
        '3e2471375464aac821502deb0ac64275' => __DIR__ . '/..' . '/symfony/polyfill-php54/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'c' => 
        array (
            'com\\extremeidea\\bidorbuy\\storeintegrator\\php\\multirequest\\' => 58,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Php55\\' => 23,
            'Symfony\\Polyfill\\Php54\\' => 23,
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Component\\HttpFoundation\\' => 33,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
        'C' => 
        array (
            'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\WooCommerce\\' => 53,
            'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\Core\\' => 46,
        ),
        'B' => 
        array (
            'Barryvdh\\Composer\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'com\\extremeidea\\bidorbuy\\storeintegrator\\php\\multirequest\\' => 
        array (
            0 => __DIR__ . '/..' . '/com.extremeidea.php/php-multirequest/src',
        ),
        'Symfony\\Polyfill\\Php55\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php55',
        ),
        'Symfony\\Polyfill\\Php54\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php54',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Component\\HttpFoundation\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/http-foundation',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\WooCommerce\\' => 
        array (
            0 => __DIR__ . '/../..' . '/classes',
        ),
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\Core\\' => 
        array (
            0 => __DIR__ . '/..' . '/com.extremeidea.bidorbuy/storeintegrator-core/src',
        ),
        'Barryvdh\\Composer\\' => 
        array (
            0 => __DIR__ . '/..' . '/barryvdh/composer-cleanup-plugin/src',
        ),
    );

    public static $classMap = array (
        'Barryvdh\\Composer\\CleanupPlugin' => __DIR__ . '/..' . '/barryvdh/composer-cleanup-plugin/src/CleanupPlugin.php',
        'Barryvdh\\Composer\\CleanupRules' => __DIR__ . '/..' . '/barryvdh/composer-cleanup-plugin/src/CleanupRules.php',
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\Core\\Core' => __DIR__ . '/..' . '/com.extremeidea.bidorbuy/storeintegrator-core/src/Core.php',
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\Core\\Db' => __DIR__ . '/..' . '/com.extremeidea.bidorbuy/storeintegrator-core/src/Db.php',
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\Core\\Debug' => __DIR__ . '/..' . '/com.extremeidea.bidorbuy/storeintegrator-core/src/Debug.php',
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\Core\\GA' => __DIR__ . '/..' . '/com.extremeidea.bidorbuy/storeintegrator-core/src/GA.php',
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\Core\\Http\\ParameterBag' => __DIR__ . '/..' . '/com.extremeidea.bidorbuy/storeintegrator-core/src/http/ParameterBag.php',
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\Core\\Http\\Request' => __DIR__ . '/..' . '/com.extremeidea.bidorbuy/storeintegrator-core/src/http/Request.php',
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\Core\\Http\\ServerBag' => __DIR__ . '/..' . '/com.extremeidea.bidorbuy/storeintegrator-core/src/http/ServerBag.php',
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\Core\\Logger' => __DIR__ . '/..' . '/com.extremeidea.bidorbuy/storeintegrator-core/src/Logger.php',
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\Core\\MySQL' => __DIR__ . '/..' . '/com.extremeidea.bidorbuy/storeintegrator-core/src/MySQL.php',
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\Core\\MySQLi' => __DIR__ . '/..' . '/com.extremeidea.bidorbuy/storeintegrator-core/src/MySQLi.php',
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\Core\\Queries' => __DIR__ . '/..' . '/com.extremeidea.bidorbuy/storeintegrator-core/src/Queries.php',
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\Core\\Settings' => __DIR__ . '/..' . '/com.extremeidea.bidorbuy/storeintegrator-core/src/Settings.php',
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\Core\\StaticHolder' => __DIR__ . '/..' . '/com.extremeidea.bidorbuy/storeintegrator-core/src/StaticHolder.php',
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\Core\\Tradefeed' => __DIR__ . '/..' . '/com.extremeidea.bidorbuy/storeintegrator-core/src/Tradefeed.php',
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\Core\\Version' => __DIR__ . '/..' . '/com.extremeidea.bidorbuy/storeintegrator-core/src/Version.php',
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\Core\\Warnings' => __DIR__ . '/..' . '/com.extremeidea.bidorbuy/storeintegrator-core/src/Warnings.php',
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\WooCommerce\\BidorbuyStoreIntegratorExport' => __DIR__ . '/../..' . '/classes/BidorbuyStoreIntegratorExport.php',
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\WooCommerce\\BidorbuyStoreIntegratorTriggers' => __DIR__ . '/../..' . '/classes/BidorbuyStoreIntegratorTriggers.php',
        'Com\\ExtremeIdea\\Bidorbuy\\StoreIntegrator\\WooCommerce\\WoocommerceCurrencyConverter' => __DIR__ . '/../..' . '/classes/WoocommerceCurrencyConverter.php',
        'Monolog\\ErrorHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/ErrorHandler.php',
        'Monolog\\Formatter\\ChromePHPFormatter' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Formatter/ChromePHPFormatter.php',
        'Monolog\\Formatter\\ElasticaFormatter' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Formatter/ElasticaFormatter.php',
        'Monolog\\Formatter\\FlowdockFormatter' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Formatter/FlowdockFormatter.php',
        'Monolog\\Formatter\\FluentdFormatter' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Formatter/FluentdFormatter.php',
        'Monolog\\Formatter\\FormatterInterface' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Formatter/FormatterInterface.php',
        'Monolog\\Formatter\\GelfMessageFormatter' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Formatter/GelfMessageFormatter.php',
        'Monolog\\Formatter\\HtmlFormatter' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Formatter/HtmlFormatter.php',
        'Monolog\\Formatter\\JsonFormatter' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Formatter/JsonFormatter.php',
        'Monolog\\Formatter\\LineFormatter' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Formatter/LineFormatter.php',
        'Monolog\\Formatter\\LogglyFormatter' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Formatter/LogglyFormatter.php',
        'Monolog\\Formatter\\LogstashFormatter' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Formatter/LogstashFormatter.php',
        'Monolog\\Formatter\\MongoDBFormatter' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Formatter/MongoDBFormatter.php',
        'Monolog\\Formatter\\NormalizerFormatter' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Formatter/NormalizerFormatter.php',
        'Monolog\\Formatter\\ScalarFormatter' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Formatter/ScalarFormatter.php',
        'Monolog\\Formatter\\WildfireFormatter' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Formatter/WildfireFormatter.php',
        'Monolog\\Handler\\AbstractHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/AbstractHandler.php',
        'Monolog\\Handler\\AbstractProcessingHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/AbstractProcessingHandler.php',
        'Monolog\\Handler\\AbstractSyslogHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/AbstractSyslogHandler.php',
        'Monolog\\Handler\\AmqpHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/AmqpHandler.php',
        'Monolog\\Handler\\BrowserConsoleHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/BrowserConsoleHandler.php',
        'Monolog\\Handler\\BufferHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/BufferHandler.php',
        'Monolog\\Handler\\ChromePHPHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/ChromePHPHandler.php',
        'Monolog\\Handler\\CouchDBHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/CouchDBHandler.php',
        'Monolog\\Handler\\CubeHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/CubeHandler.php',
        'Monolog\\Handler\\Curl\\Util' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/Curl/Util.php',
        'Monolog\\Handler\\DeduplicationHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/DeduplicationHandler.php',
        'Monolog\\Handler\\DoctrineCouchDBHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/DoctrineCouchDBHandler.php',
        'Monolog\\Handler\\DynamoDbHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/DynamoDbHandler.php',
        'Monolog\\Handler\\ElasticSearchHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/ElasticSearchHandler.php',
        'Monolog\\Handler\\ErrorLogHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/ErrorLogHandler.php',
        'Monolog\\Handler\\FilterHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/FilterHandler.php',
        'Monolog\\Handler\\FingersCrossedHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/FingersCrossedHandler.php',
        'Monolog\\Handler\\FingersCrossed\\ActivationStrategyInterface' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/FingersCrossed/ActivationStrategyInterface.php',
        'Monolog\\Handler\\FingersCrossed\\ChannelLevelActivationStrategy' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/FingersCrossed/ChannelLevelActivationStrategy.php',
        'Monolog\\Handler\\FingersCrossed\\ErrorLevelActivationStrategy' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/FingersCrossed/ErrorLevelActivationStrategy.php',
        'Monolog\\Handler\\FirePHPHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/FirePHPHandler.php',
        'Monolog\\Handler\\FleepHookHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/FleepHookHandler.php',
        'Monolog\\Handler\\FlowdockHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/FlowdockHandler.php',
        'Monolog\\Handler\\GelfHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/GelfHandler.php',
        'Monolog\\Handler\\GroupHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/GroupHandler.php',
        'Monolog\\Handler\\HandlerInterface' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/HandlerInterface.php',
        'Monolog\\Handler\\HandlerWrapper' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/HandlerWrapper.php',
        'Monolog\\Handler\\HipChatHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/HipChatHandler.php',
        'Monolog\\Handler\\IFTTTHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/IFTTTHandler.php',
        'Monolog\\Handler\\InsightOpsHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/InsightOpsHandler.php',
        'Monolog\\Handler\\LogEntriesHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/LogEntriesHandler.php',
        'Monolog\\Handler\\LogglyHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/LogglyHandler.php',
        'Monolog\\Handler\\MailHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/MailHandler.php',
        'Monolog\\Handler\\MandrillHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/MandrillHandler.php',
        'Monolog\\Handler\\MissingExtensionException' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/MissingExtensionException.php',
        'Monolog\\Handler\\MongoDBHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/MongoDBHandler.php',
        'Monolog\\Handler\\NativeMailerHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/NativeMailerHandler.php',
        'Monolog\\Handler\\NewRelicHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/NewRelicHandler.php',
        'Monolog\\Handler\\NullHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/NullHandler.php',
        'Monolog\\Handler\\PHPConsoleHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/PHPConsoleHandler.php',
        'Monolog\\Handler\\PsrHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/PsrHandler.php',
        'Monolog\\Handler\\PushoverHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/PushoverHandler.php',
        'Monolog\\Handler\\RavenHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/RavenHandler.php',
        'Monolog\\Handler\\RedisHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/RedisHandler.php',
        'Monolog\\Handler\\RollbarHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/RollbarHandler.php',
        'Monolog\\Handler\\RotatingFileHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/RotatingFileHandler.php',
        'Monolog\\Handler\\SamplingHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/SamplingHandler.php',
        'Monolog\\Handler\\SlackHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/SlackHandler.php',
        'Monolog\\Handler\\SlackWebhookHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/SlackWebhookHandler.php',
        'Monolog\\Handler\\Slack\\SlackRecord' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/Slack/SlackRecord.php',
        'Monolog\\Handler\\SlackbotHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/SlackbotHandler.php',
        'Monolog\\Handler\\SocketHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/SocketHandler.php',
        'Monolog\\Handler\\StreamHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/StreamHandler.php',
        'Monolog\\Handler\\SwiftMailerHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/SwiftMailerHandler.php',
        'Monolog\\Handler\\SyslogHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/SyslogHandler.php',
        'Monolog\\Handler\\SyslogUdpHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/SyslogUdpHandler.php',
        'Monolog\\Handler\\SyslogUdp\\UdpSocket' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/SyslogUdp/UdpSocket.php',
        'Monolog\\Handler\\TestHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/TestHandler.php',
        'Monolog\\Handler\\WhatFailureGroupHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/WhatFailureGroupHandler.php',
        'Monolog\\Handler\\ZendMonitorHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Handler/ZendMonitorHandler.php',
        'Monolog\\Logger' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Logger.php',
        'Monolog\\Processor\\GitProcessor' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Processor/GitProcessor.php',
        'Monolog\\Processor\\IntrospectionProcessor' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Processor/IntrospectionProcessor.php',
        'Monolog\\Processor\\MemoryPeakUsageProcessor' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Processor/MemoryPeakUsageProcessor.php',
        'Monolog\\Processor\\MemoryProcessor' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Processor/MemoryProcessor.php',
        'Monolog\\Processor\\MemoryUsageProcessor' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Processor/MemoryUsageProcessor.php',
        'Monolog\\Processor\\MercurialProcessor' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Processor/MercurialProcessor.php',
        'Monolog\\Processor\\ProcessIdProcessor' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Processor/ProcessIdProcessor.php',
        'Monolog\\Processor\\ProcessorInterface' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Processor/ProcessorInterface.php',
        'Monolog\\Processor\\PsrLogMessageProcessor' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Processor/PsrLogMessageProcessor.php',
        'Monolog\\Processor\\TagProcessor' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Processor/TagProcessor.php',
        'Monolog\\Processor\\UidProcessor' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Processor/UidProcessor.php',
        'Monolog\\Processor\\WebProcessor' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Processor/WebProcessor.php',
        'Monolog\\Registry' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Registry.php',
        'Monolog\\ResettableInterface' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/ResettableInterface.php',
        'Monolog\\SignalHandler' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/SignalHandler.php',
        'Monolog\\Utils' => __DIR__ . '/..' . '/monolog/monolog/src/Monolog/Utils.php',
        'Psr\\Log\\AbstractLogger' => __DIR__ . '/..' . '/psr/log/Psr/Log/AbstractLogger.php',
        'Psr\\Log\\InvalidArgumentException' => __DIR__ . '/..' . '/psr/log/Psr/Log/InvalidArgumentException.php',
        'Psr\\Log\\LogLevel' => __DIR__ . '/..' . '/psr/log/Psr/Log/LogLevel.php',
        'Psr\\Log\\LoggerAwareInterface' => __DIR__ . '/..' . '/psr/log/Psr/Log/LoggerAwareInterface.php',
        'Psr\\Log\\LoggerAwareTrait' => __DIR__ . '/..' . '/psr/log/Psr/Log/LoggerAwareTrait.php',
        'Psr\\Log\\LoggerInterface' => __DIR__ . '/..' . '/psr/log/Psr/Log/LoggerInterface.php',
        'Psr\\Log\\LoggerTrait' => __DIR__ . '/..' . '/psr/log/Psr/Log/LoggerTrait.php',
        'Psr\\Log\\NullLogger' => __DIR__ . '/..' . '/psr/log/Psr/Log/NullLogger.php',
        'Psr\\Log\\Test\\DummyTest' => __DIR__ . '/..' . '/psr/log/Psr/Log/Test/LoggerInterfaceTest.php',
        'Psr\\Log\\Test\\LoggerInterfaceTest' => __DIR__ . '/..' . '/psr/log/Psr/Log/Test/LoggerInterfaceTest.php',
        'Psr\\Log\\Test\\TestLogger' => __DIR__ . '/..' . '/psr/log/Psr/Log/Test/TestLogger.php',
        'Symfony\\Component\\HttpFoundation\\AcceptHeader' => __DIR__ . '/..' . '/symfony/http-foundation/AcceptHeader.php',
        'Symfony\\Component\\HttpFoundation\\AcceptHeaderItem' => __DIR__ . '/..' . '/symfony/http-foundation/AcceptHeaderItem.php',
        'Symfony\\Component\\HttpFoundation\\ApacheRequest' => __DIR__ . '/..' . '/symfony/http-foundation/ApacheRequest.php',
        'Symfony\\Component\\HttpFoundation\\BinaryFileResponse' => __DIR__ . '/..' . '/symfony/http-foundation/BinaryFileResponse.php',
        'Symfony\\Component\\HttpFoundation\\Cookie' => __DIR__ . '/..' . '/symfony/http-foundation/Cookie.php',
        'Symfony\\Component\\HttpFoundation\\Exception\\ConflictingHeadersException' => __DIR__ . '/..' . '/symfony/http-foundation/Exception/ConflictingHeadersException.php',
        'Symfony\\Component\\HttpFoundation\\ExpressionRequestMatcher' => __DIR__ . '/..' . '/symfony/http-foundation/ExpressionRequestMatcher.php',
        'Symfony\\Component\\HttpFoundation\\FileBag' => __DIR__ . '/..' . '/symfony/http-foundation/FileBag.php',
        'Symfony\\Component\\HttpFoundation\\File\\Exception\\AccessDeniedException' => __DIR__ . '/..' . '/symfony/http-foundation/File/Exception/AccessDeniedException.php',
        'Symfony\\Component\\HttpFoundation\\File\\Exception\\FileException' => __DIR__ . '/..' . '/symfony/http-foundation/File/Exception/FileException.php',
        'Symfony\\Component\\HttpFoundation\\File\\Exception\\FileNotFoundException' => __DIR__ . '/..' . '/symfony/http-foundation/File/Exception/FileNotFoundException.php',
        'Symfony\\Component\\HttpFoundation\\File\\Exception\\UnexpectedTypeException' => __DIR__ . '/..' . '/symfony/http-foundation/File/Exception/UnexpectedTypeException.php',
        'Symfony\\Component\\HttpFoundation\\File\\Exception\\UploadException' => __DIR__ . '/..' . '/symfony/http-foundation/File/Exception/UploadException.php',
        'Symfony\\Component\\HttpFoundation\\File\\File' => __DIR__ . '/..' . '/symfony/http-foundation/File/File.php',
        'Symfony\\Component\\HttpFoundation\\File\\MimeType\\ExtensionGuesser' => __DIR__ . '/..' . '/symfony/http-foundation/File/MimeType/ExtensionGuesser.php',
        'Symfony\\Component\\HttpFoundation\\File\\MimeType\\ExtensionGuesserInterface' => __DIR__ . '/..' . '/symfony/http-foundation/File/MimeType/ExtensionGuesserInterface.php',
        'Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileBinaryMimeTypeGuesser' => __DIR__ . '/..' . '/symfony/http-foundation/File/MimeType/FileBinaryMimeTypeGuesser.php',
        'Symfony\\Component\\HttpFoundation\\File\\MimeType\\FileinfoMimeTypeGuesser' => __DIR__ . '/..' . '/symfony/http-foundation/File/MimeType/FileinfoMimeTypeGuesser.php',
        'Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeExtensionGuesser' => __DIR__ . '/..' . '/symfony/http-foundation/File/MimeType/MimeTypeExtensionGuesser.php',
        'Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeGuesser' => __DIR__ . '/..' . '/symfony/http-foundation/File/MimeType/MimeTypeGuesser.php',
        'Symfony\\Component\\HttpFoundation\\File\\MimeType\\MimeTypeGuesserInterface' => __DIR__ . '/..' . '/symfony/http-foundation/File/MimeType/MimeTypeGuesserInterface.php',
        'Symfony\\Component\\HttpFoundation\\File\\UploadedFile' => __DIR__ . '/..' . '/symfony/http-foundation/File/UploadedFile.php',
        'Symfony\\Component\\HttpFoundation\\HeaderBag' => __DIR__ . '/..' . '/symfony/http-foundation/HeaderBag.php',
        'Symfony\\Component\\HttpFoundation\\IpUtils' => __DIR__ . '/..' . '/symfony/http-foundation/IpUtils.php',
        'Symfony\\Component\\HttpFoundation\\JsonResponse' => __DIR__ . '/..' . '/symfony/http-foundation/JsonResponse.php',
        'Symfony\\Component\\HttpFoundation\\ParameterBag' => __DIR__ . '/..' . '/symfony/http-foundation/ParameterBag.php',
        'Symfony\\Component\\HttpFoundation\\RedirectResponse' => __DIR__ . '/..' . '/symfony/http-foundation/RedirectResponse.php',
        'Symfony\\Component\\HttpFoundation\\Request' => __DIR__ . '/..' . '/symfony/http-foundation/Request.php',
        'Symfony\\Component\\HttpFoundation\\RequestMatcher' => __DIR__ . '/..' . '/symfony/http-foundation/RequestMatcher.php',
        'Symfony\\Component\\HttpFoundation\\RequestMatcherInterface' => __DIR__ . '/..' . '/symfony/http-foundation/RequestMatcherInterface.php',
        'Symfony\\Component\\HttpFoundation\\RequestStack' => __DIR__ . '/..' . '/symfony/http-foundation/RequestStack.php',
        'Symfony\\Component\\HttpFoundation\\Response' => __DIR__ . '/..' . '/symfony/http-foundation/Response.php',
        'Symfony\\Component\\HttpFoundation\\ResponseHeaderBag' => __DIR__ . '/..' . '/symfony/http-foundation/ResponseHeaderBag.php',
        'Symfony\\Component\\HttpFoundation\\ServerBag' => __DIR__ . '/..' . '/symfony/http-foundation/ServerBag.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Attribute\\AttributeBag' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Attribute/AttributeBag.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Attribute\\AttributeBagInterface' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Attribute/AttributeBagInterface.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Attribute\\NamespacedAttributeBag' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Attribute/NamespacedAttributeBag.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Flash\\AutoExpireFlashBag' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Flash/AutoExpireFlashBag.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Flash\\FlashBag' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Flash/FlashBag.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Flash\\FlashBagInterface' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Flash/FlashBagInterface.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Session' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Session.php',
        'Symfony\\Component\\HttpFoundation\\Session\\SessionBagInterface' => __DIR__ . '/..' . '/symfony/http-foundation/Session/SessionBagInterface.php',
        'Symfony\\Component\\HttpFoundation\\Session\\SessionInterface' => __DIR__ . '/..' . '/symfony/http-foundation/Session/SessionInterface.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Storage\\Handler\\LegacyPdoSessionHandler' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Storage/Handler/LegacyPdoSessionHandler.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Storage\\Handler\\MemcacheSessionHandler' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Storage/Handler/MemcacheSessionHandler.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Storage\\Handler\\MemcachedSessionHandler' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Storage/Handler/MemcachedSessionHandler.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Storage\\Handler\\MongoDbSessionHandler' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Storage/Handler/MongoDbSessionHandler.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Storage\\Handler\\NativeFileSessionHandler' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Storage/Handler/NativeFileSessionHandler.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Storage\\Handler\\NativeSessionHandler' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Storage/Handler/NativeSessionHandler.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Storage\\Handler\\NullSessionHandler' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Storage/Handler/NullSessionHandler.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Storage\\Handler\\PdoSessionHandler' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Storage/Handler/PdoSessionHandler.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Storage\\Handler\\WriteCheckSessionHandler' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Storage/Handler/WriteCheckSessionHandler.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Storage\\MetadataBag' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Storage/MetadataBag.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Storage\\MockArraySessionStorage' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Storage/MockArraySessionStorage.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Storage\\MockFileSessionStorage' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Storage/MockFileSessionStorage.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Storage\\NativeSessionStorage' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Storage/NativeSessionStorage.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Storage\\PhpBridgeSessionStorage' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Storage/PhpBridgeSessionStorage.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Storage\\Proxy\\AbstractProxy' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Storage/Proxy/AbstractProxy.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Storage\\Proxy\\NativeProxy' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Storage/Proxy/NativeProxy.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Storage\\Proxy\\SessionHandlerProxy' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Storage/Proxy/SessionHandlerProxy.php',
        'Symfony\\Component\\HttpFoundation\\Session\\Storage\\SessionStorageInterface' => __DIR__ . '/..' . '/symfony/http-foundation/Session/Storage/SessionStorageInterface.php',
        'Symfony\\Component\\HttpFoundation\\StreamedResponse' => __DIR__ . '/..' . '/symfony/http-foundation/StreamedResponse.php',
        'Symfony\\Polyfill\\Mbstring\\Mbstring' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/Mbstring.php',
        'Symfony\\Polyfill\\Php54\\Php54' => __DIR__ . '/..' . '/symfony/polyfill-php54/Php54.php',
        'Symfony\\Polyfill\\Php55\\Php55' => __DIR__ . '/..' . '/symfony/polyfill-php55/Php55.php',
        'Symfony\\Polyfill\\Php55\\Php55ArrayColumn' => __DIR__ . '/..' . '/symfony/polyfill-php55/Php55ArrayColumn.php',
        'com\\extremeidea\\bidorbuy\\storeintegrator\\php\\multirequest\\MultiRequestCallbacks' => __DIR__ . '/..' . '/com.extremeidea.php/php-multirequest/src/Callbacks.php',
        'com\\extremeidea\\bidorbuy\\storeintegrator\\php\\multirequest\\MultiRequestDefaults' => __DIR__ . '/..' . '/com.extremeidea.php/php-multirequest/src/Defaults.php',
        'com\\extremeidea\\bidorbuy\\storeintegrator\\php\\multirequest\\MultiRequestHandler' => __DIR__ . '/..' . '/com.extremeidea.php/php-multirequest/src/Handler.php',
        'com\\extremeidea\\bidorbuy\\storeintegrator\\php\\multirequest\\MultiRequestQueue' => __DIR__ . '/..' . '/com.extremeidea.php/php-multirequest/src/Queue.php',
        'com\\extremeidea\\bidorbuy\\storeintegrator\\php\\multirequest\\MultiRequestRequest' => __DIR__ . '/..' . '/com.extremeidea.php/php-multirequest/src/Request.php',
        'com\\extremeidea\\bidorbuy\\storeintegrator\\php\\multirequest\\MultiRequestSession' => __DIR__ . '/..' . '/com.extremeidea.php/php-multirequest/src/Session.php',
        'com\\extremeidea\\bidorbuy\\storeintegrator\\php\\multirequest\\errors\\MultiRequestException' => __DIR__ . '/..' . '/com.extremeidea.php/php-multirequest/src/Errors/MultiRequestException.php',
        'com\\extremeidea\\bidorbuy\\storeintegrator\\php\\multirequest\\errors\\MultiRequestFailedConnection' => __DIR__ . '/..' . '/com.extremeidea.php/php-multirequest/src/Errors/MultiRequestFailedConnection.php',
        'com\\extremeidea\\bidorbuy\\storeintegrator\\php\\multirequest\\errors\\MultiRequestFailedResponse' => __DIR__ . '/..' . '/com.extremeidea.php/php-multirequest/src/Errors/MultiRequestFailedResponse.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2ef8b491792689d39ce5599da3ed681a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2ef8b491792689d39ce5599da3ed681a::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2ef8b491792689d39ce5599da3ed681a::$classMap;

        }, null, ClassLoader::class);
    }
}
