<?php

$vendorName = 'mynamespace';
$packageName = 'CamelCasedPackage';
$packageDescription = 'A package for assisting with stuff';

// Define the root directory for the package
$rootDir = __DIR__ . '/' . $packageName;

// Define the directory for the source files
$srcDir = $rootDir . '/src';

// Define the directory for the tests
$testsDir = $rootDir . '/tests';

// Define the namespace for the package
$packageNamespace = ucfirst($packageName);

// Create the directories for the package
mkdir($rootDir);
mkdir($srcDir);
mkdir($testsDir);

// Convert Camel to Kebab Case
$kebabCaseStr = preg_replace('/[A-Z]/', '-$0', $packageName);
$kebabCasePackageName = strtolower(trim($kebabCaseStr, '-'));
    
// Generate the composer.json file
$composerJsonData = [
    'name' => $vendorName . '/' . $kebabCasePackageName,
    'description' => 'A package for managing lists',
    'type' => 'library',
    'license' => 'MIT',
    'authors' => [
        [
            'name' => 'Your Name',
            'email' => 'your-email@example.com'
        ]
    ],
    'require' => [
        'php' => '^7.4 || ^8.0',
        'illuminate/support' => '^8.0'
    ],
    'autoload' => [
        'psr-4' => [
            $vendorName . '\\' . $packageNamespace . '\\' => 'src/'
        ]
    ],
    'minimum-stability' => 'dev',
    'prefer-stable' => true
];

$composerJson = json_encode($composerJsonData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
file_put_contents($rootDir . '/composer.json', $composerJson);

// Generate the main class file
$classContent = <<<EOD
<?php

namespace $vendorName\\$packageNamespace;

class $packageNamespace
{
    // 
}
EOD;

file_put_contents($srcDir . '/' . $packageNamespace . '.php', $classContent);

$serviceProviderClassName = $packageNamespace . 'ServiceProvider';
// Generate the service provider file
$serviceProviderContent = <<<EOD
<?php

namespace $vendorName\\$packageNamespace;

use Illuminate\Support\ServiceProvider;

class $serviceProviderClassName extends ServiceProvider
{
    public function register()
    {
        // 
    }

    public function boot()
    {
        // 
    }
}
EOD;

file_put_contents($srcDir . '/' . $packageNamespace . 'ServiceProvider.php', $serviceProviderContent);

// Generate the test file
$testClassName = $packageNamespace . 'Test';
$testContent = <<<EOD
<?php

namespace $vendorName\\$packageNamespace\Tests;

use PHPUnit\Framework\TestCase;

class $testClassName extends TestCase
{
    public function testExample()
    {
        \$this->assertTrue(true);
    }
}
EOD;

file_put_contents($testsDir . '/' . $packageNamespace . 'Test.php', $testContent);

$autoloadNameSpacedClassName = $packageNamespace . 'ServiceProvider';
// Generate the main package file
$packageContent = <<<EOD
<?php

require_once __DIR__ . '/vendor/autoload.php';

use $vendorName\\$packageNamespace\\$autoloadNameSpacedClassName;

\$app = new Illuminate\Foundation\Application;
\$app->register($vendorName\\$packageNamespace\\$autoloadNameSpacedClassName::class);

EOD;

file_put_contents($rootDir . '/' . $kebabCasePackageName . '.php', $packageContent);

echo "Package files generated successfully!\n";