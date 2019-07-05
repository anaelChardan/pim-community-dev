<?php

use PHPUnit\Framework\TestSuite;
use PHPUnit\Util\Configuration;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

require __DIR__ . '/../vendor/autoload.php';

class ListPhpUnitClassesCommand extends Command
{
    protected static $defaultName = 'list';

    protected function configure()
    {
        $this->addArgument('suite', InputArgument::REQUIRED);
        $this->addOption('exclude-criticals', null, InputOption::VALUE_NONE, 'Exclude the classes containing at least one critical test.');
        $this->addOption('only-criticals', null, InputOption::VALUE_NONE, 'Keep the classes containing at least one critical test.');
        $this->setDescription('List the test classes impacted by a PHPUnit suite.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configuration = Configuration::getInstance(__DIR__ . '/../app/phpunit.xml.dist');
        $testSuiteConfiguration = $configuration->getTestSuiteConfiguration();

        $suite = $this->findSuite($testSuiteConfiguration, $input->getArgument('suite'));

        if (true === $input->getOption('only-criticals')) {
            $testClasses = $this->classesInsideGroup($suite, 'critical');
        } elseif (true === $input->getOption('exclude-criticals')) {
            $criticalClasses = $this->classesInsideGroup($suite, 'critical');
            $defaultClasses = $this->classesInsideGroup($suite, 'default');
            $testClasses = array_diff($defaultClasses, $criticalClasses);
        } else {
            $testClasses = $this->classesInsideGroup($suite, 'default');
        }

        array_map(
            function ($testClass) {
                echo $testClass . "\n";
            },
            $testClasses
        );
    }

    private function classesInsideGroup(TestSuite $suite, string $groupName): array
    {
        if (!in_array($groupName, $suite->getGroups())) {
            throw new Exception(sprintf('The group "%s" does not exist in the suite "%s".', $groupName, $suite->getName()));
        }

        $group = $suite->getGroupDetails()[$groupName];

        return array_map(
            function ($suite) {
                return $suite->getName();
            },
            $group
        );
    }

    private function findSuite(TestSuite $testSuiteConfiguration, $suiteName): TestSuite
    {
        $matchingSuites = array_filter(
            $testSuiteConfiguration->tests(),
            function ($suite) use ($suiteName) {
                return $suiteName === $suite->getName();
            }
        );

        if (empty($matchingSuites)) {
            throw new \Exception(sprintf('The suite "%s" does not exist!', $suiteName));
        }

        return array_pop($matchingSuites);
    }
}

$application = new Application();
$application->add(new ListPhpUnitClassesCommand());
$application->run();