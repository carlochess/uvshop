<?php

namespace Map;

use \MetodoPago;
use \MetodoPagoQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'metodo_pago' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class MetodoPagoTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.MetodoPagoTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'uvshop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'metodo_pago';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\MetodoPago';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'MetodoPago';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the ID_FACTURA field
     */
    const ID_FACTURA = 'metodo_pago.ID_FACTURA';

    /**
     * the column name for the ID_PAGO field
     */
    const ID_PAGO = 'metodo_pago.ID_PAGO';

    /**
     * the column name for the TIPO field
     */
    const TIPO = 'metodo_pago.TIPO';

    /**
     * the column name for the CUOTAS field
     */
    const CUOTAS = 'metodo_pago.CUOTAS';

    /**
     * the column name for the MONTO field
     */
    const MONTO = 'metodo_pago.MONTO';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('IdFactura', 'IdPago', 'Tipo', 'Cuotas', 'Monto', ),
        self::TYPE_STUDLYPHPNAME => array('idFactura', 'idPago', 'tipo', 'cuotas', 'monto', ),
        self::TYPE_COLNAME       => array(MetodoPagoTableMap::ID_FACTURA, MetodoPagoTableMap::ID_PAGO, MetodoPagoTableMap::TIPO, MetodoPagoTableMap::CUOTAS, MetodoPagoTableMap::MONTO, ),
        self::TYPE_RAW_COLNAME   => array('ID_FACTURA', 'ID_PAGO', 'TIPO', 'CUOTAS', 'MONTO', ),
        self::TYPE_FIELDNAME     => array('id_factura', 'id_pago', 'tipo', 'cuotas', 'monto', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdFactura' => 0, 'IdPago' => 1, 'Tipo' => 2, 'Cuotas' => 3, 'Monto' => 4, ),
        self::TYPE_STUDLYPHPNAME => array('idFactura' => 0, 'idPago' => 1, 'tipo' => 2, 'cuotas' => 3, 'monto' => 4, ),
        self::TYPE_COLNAME       => array(MetodoPagoTableMap::ID_FACTURA => 0, MetodoPagoTableMap::ID_PAGO => 1, MetodoPagoTableMap::TIPO => 2, MetodoPagoTableMap::CUOTAS => 3, MetodoPagoTableMap::MONTO => 4, ),
        self::TYPE_RAW_COLNAME   => array('ID_FACTURA' => 0, 'ID_PAGO' => 1, 'TIPO' => 2, 'CUOTAS' => 3, 'MONTO' => 4, ),
        self::TYPE_FIELDNAME     => array('id_factura' => 0, 'id_pago' => 1, 'tipo' => 2, 'cuotas' => 3, 'monto' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('metodo_pago');
        $this->setPhpName('MetodoPago');
        $this->setClassName('\\MetodoPago');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addForeignKey('ID_FACTURA', 'IdFactura', 'INTEGER', 'factura', 'ID_FACTURA', true, 5, null);
        $this->addPrimaryKey('ID_PAGO', 'IdPago', 'INTEGER', true, 40, null);
        $this->addColumn('TIPO', 'Tipo', 'VARCHAR', true, 3, null);
        $this->addColumn('CUOTAS', 'Cuotas', 'INTEGER', true, null, null);
        $this->addColumn('MONTO', 'Monto', 'INTEGER', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Factura', '\\Factura', RelationMap::MANY_TO_ONE, array('id_factura' => 'id_factura', ), 'CASCADE', null);
    } // buildRelations()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('IdPago', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('IdPago', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {

            return (int) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 1 + $offset
                            : self::translateFieldName('IdPago', TableMap::TYPE_PHPNAME, $indexType)
                        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? MetodoPagoTableMap::CLASS_DEFAULT : MetodoPagoTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     * @return array (MetodoPago object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = MetodoPagoTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = MetodoPagoTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + MetodoPagoTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MetodoPagoTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            MetodoPagoTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = MetodoPagoTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = MetodoPagoTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MetodoPagoTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(MetodoPagoTableMap::ID_FACTURA);
            $criteria->addSelectColumn(MetodoPagoTableMap::ID_PAGO);
            $criteria->addSelectColumn(MetodoPagoTableMap::TIPO);
            $criteria->addSelectColumn(MetodoPagoTableMap::CUOTAS);
            $criteria->addSelectColumn(MetodoPagoTableMap::MONTO);
        } else {
            $criteria->addSelectColumn($alias . '.ID_FACTURA');
            $criteria->addSelectColumn($alias . '.ID_PAGO');
            $criteria->addSelectColumn($alias . '.TIPO');
            $criteria->addSelectColumn($alias . '.CUOTAS');
            $criteria->addSelectColumn($alias . '.MONTO');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(MetodoPagoTableMap::DATABASE_NAME)->getTable(MetodoPagoTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(MetodoPagoTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(MetodoPagoTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new MetodoPagoTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a MetodoPago or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or MetodoPago object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MetodoPagoTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \MetodoPago) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MetodoPagoTableMap::DATABASE_NAME);
            $criteria->add(MetodoPagoTableMap::ID_PAGO, (array) $values, Criteria::IN);
        }

        $query = MetodoPagoQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { MetodoPagoTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { MetodoPagoTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the metodo_pago table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return MetodoPagoQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a MetodoPago or Criteria object.
     *
     * @param mixed               $criteria Criteria or MetodoPago object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MetodoPagoTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from MetodoPago object
        }

        if ($criteria->containsKey(MetodoPagoTableMap::ID_PAGO) && $criteria->keyContainsValue(MetodoPagoTableMap::ID_PAGO) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.MetodoPagoTableMap::ID_PAGO.')');
        }


        // Set the correct dbName
        $query = MetodoPagoQuery::create()->mergeWith($criteria);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = $query->doInsert($con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

} // MetodoPagoTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
MetodoPagoTableMap::buildTableMap();
