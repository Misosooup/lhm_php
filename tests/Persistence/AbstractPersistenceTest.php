<?php


namespace tests\Persistence;

use Phinx\Db\Adapter\AdapterInterface;
use Phinx\Db\Adapter\MysqlAdapter;
use Symfony\Component\Console\Output\NullOutput;


abstract class AbstractPersistenceTest extends \PHPUnit_Framework_TestCase
{
    /** @var AdapterInterface */
    protected $adapter;

    protected function setUp()
    {
        parent::setUp();

        $options = [
            'host' => getenv('LHM_DATABASE_HOST') ?: 'localhost',
            'name' => getenv('LHM_DATABASE_NAME') ?: 'lhm_php_test',
            'user' => getenv('LHM_DATABASE_USER') ?: 'root',
            'pass' => getenv('LHM_DATABASE_PASSWORD') ?: null,
            'port' => getenv('LHM_DATABASE_PORT') ?: 3306
        ];

        $this->adapter = new MysqlAdapter($options, new NullOutput());
        $this->adapter->setOptions($options);

        // ensure the database is empty for each test
        $this->adapter->dropDatabase($options['name']);
        $this->adapter->createDatabase($options['name']);

        // leave the adapter in a disconnected state for each test
        $this->adapter->disconnect();
    }


}
