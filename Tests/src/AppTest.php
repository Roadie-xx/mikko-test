<?php

use App\App;
use App\Settings;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    /**
     * Create a stub for the Settings class.
     *
     * @param $month
     * @param $year
     * @param $filename
     *
     * @return PHPUnit_Framework_MockObject_MockObject|Settings
     */
    private function mockSettings($month, $year, $filename) {
        /**
         * @var $stub Settings|\PHPUnit_Framework_MockObject_MockObject
         */
        $stub = $this->createMock(Settings::class);

        // Configure the stub.
        $stub->method('getMonth')
             ->willReturn($month);

        $stub->method('getYear')
             ->willReturn($year);

        $stub->method('getFilename')
             ->willReturn($filename);

        return $stub;
    }

    /**
     * @param $className
     * @param $propertyName
     * @param $instance
     *
     * @return mixed
     * @throws ReflectionException
     * @throws Exception
     */
    public function getPrivateProperty($className, $propertyName, $instance)
    {
        $reflector = new \ReflectionClass($className);

        while (! $reflector->hasProperty($propertyName)) {
            $reflector = $reflector->getParentClass();

            if ($reflector === false) {
                throw new \Exception('Property "' . $propertyName . '" not found in ' . $className);
            }
        }

        $property = $reflector->getProperty($propertyName);
        $property->setAccessible(true);

        return $property->getValue($instance);
    }

    /**
     * @param $className
     * @param $methodName
     *
     * @return \ReflectionMethod
     * @throws ReflectionException
     */
    public function getPrivateMethod($className, $methodName)
    {
        $reflector = new \ReflectionClass($className);
        $method    = $reflector->getMethod($methodName);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * @covers App::__construct()
     *
     * @throws Exception
     */
    public function testAppCanBeCreated()
    {
        $instance = $this->mockSettings(2, 2019, 'testFile.csv');

        $app = new App($instance);

        $this->assertInstanceOf(App::class, $app);

        $settings = $this->getPrivateProperty(App::class, 'settings', $app);

        $this->assertInstanceOf(Settings::class, $settings);

        $this->assertEquals(2019, $settings->getYear());
        $this->assertEquals(2, $settings->getMonth());
        $this->assertEquals('testFile.csv', $settings->getFilename());
    }

    /**
     * @covers App::__construct()
     *
     * @throws Exception
     */
    public function testAppHasTheRightMonthNames()
    {
        $instance = $this->mockSettings(11, 2018, 'testFile.csv');

        $app = new App($instance);

        $this->assertInstanceOf(App::class, $app);

        $months = $this->getPrivateProperty(App::class, 'months', $app);

        $expectedResult = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $this->assertEquals($expectedResult, $months);
    }

    /**
     * @covers App::__construct()
     * @covers App::buildHeader()
     *
     * @throws Exception
     */
    public function testAppCanBuildHeader()
    {
        $instance = $this->mockSettings(2, 2019, 'testFile.csv');

        $app = new App($instance);

        $this->assertInstanceOf(App::class, $app);

        $method = $this->getPrivateMethod(App::class, 'buildHeader');
        $method->invoke($app);

        $csvData = $this->getPrivateProperty(App::class, 'csvData', $app);

        $expectedResult = [
            ['Month', 'Salary payment date', 'Bonus payment date']
        ];

        $this->assertEquals($expectedResult, $csvData);
    }


    /**
     * @covers App::__construct()
     * @covers App::buildHeader()
     * @covers App::addData()
     *
     * @throws Exception
     */
    public function testAppCanAddData()
    {
        $instance = $this->mockSettings(11, 2018, 'testFile.csv');

        $app = new App($instance);

        $this->assertInstanceOf(App::class, $app);

        $method = $this->getPrivateMethod(App::class, 'addData');
        $method->invoke($app);

        $csvData = $this->getPrivateProperty(App::class, 'csvData', $app);

        $expectedResult = [
            ['November', '2018-11-30', '2018-11-15'],
            ['December', '2018-12-31', '2018-12-19'],
        ];

        $this->assertEquals($expectedResult, $csvData);
    }





}
