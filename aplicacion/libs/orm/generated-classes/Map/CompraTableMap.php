<?php

namespace Map;

use \Compra;
use \CompraQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'compra' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CompraTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.CompraTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'uvshop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'compra';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Compra';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Compra';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the ID_PROD field
     */
    const ID_PROD = 'compra.ID_PROD';

    /**
     * the column name for the ID_COMPRA field
     */
    const ID_COMPRA = 'compra.ID_COMPRA';

    /**
     * the column name for the ID_FACTURA field
     */
    const ID_FACTURA = 'compra.ID_FACTURA';

    /**
     * the column name for the CANT_PROD field
     */
    const CANT_PROD = 'compra.CANT_PROD';

    /**
     * the column name for the VALOR field
     */
    const VALOR = 'compra.VALOR';

    /**
     * the column name for the IVA field
     */
    const IVA = 'compra.IVA';

    /**
     * the column name for the PORCETAJE_RED field
     */
    const PORCETAJE_RED = 'compra.PORCETAJE_RED';

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
        self::TYPE_PHPNAME       => array('IdProd', 'IdCompra', 'IdFactura', 'CantProd', 'Valor', 'Iva', 'PorcetajeRed', ),
        self::TYPE_STUDLYPHPNAME => array('idProd', 'idCompra', 'idFactura', 'cantProd', 'valor', 'iva', 'porcetajeRed', ),
        self::TYPE_COLNAME       => array(CompraTableMap::ID_PROD, CompraTableMap::ID_COMPRA, CompraTableMap::ID_FACTURA, CompraTableMap::CANT_PROD, CompraTableMap::VALOR, CompraTableMap::IVA, CompraTableMap::PORCETAJE_RED, ),
        self::TYPE_RAW_COLNAME   => array('ID_PROD', 'ID_COMPRA', 'ID_FACTURA', 'CANT_PROD', 'VALOR', 'IVA', 'PORCETAJE_RED', ),
        self::TYPE_FIELDNAME     => array('id_prod', 'id_compra', 'id_factura', 'cant_prod', 'valor', 'iva', 'porcetaje_red', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdProd' => 0, 'IdCompra' => 1, 'IdFactura' => 2, 'CantProd' => 3, 'Valor' => 4, 'Iva' => 5, 'PorcetajeRed' => 6, ),
        self::TYPE_STUDLYPHPNAME => array('idProd' => 0, 'idCompra' => 1, 'idFactura' => 2, 'cantProd' => 3, 'valor' => 4, 'iva' => 5, 'porcetajeRed' => 6, ),
        self::TYPE_COLNAME       => array(CompraTableMap::ID_PROD => 0, CompraTableMap::ID_COMPRA => 1, CompraTableMap::ID_FACTURA => 2, CompraTableMap::CANT_PROD => 3, CompraTableMap::VALOR => 4, CompraTableMap::IVA => 5, CompraTableMap::PORCETAJE_RED => 6, ),
        self::TYPE_RAW_COLNAME   => array('ID_PROD' => 0, 'ID_COMPRA' => 1, 'ID_FACTURA' => 2, 'CANT_PROD' => 3, 'VALOR' => 4, 'IVA' => 5, 'PORCETAJE_RED' => 6, ),
        self::TYPE_FIELDNAME     => array('id_prod' => 0, 'id_compra' => 1, 'id_factura' => 2, 'cant_prod' => 3, 'valor' => 4, 'iva' => 5, 'porcetaje_red' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setName('compra');
        $this->setPhpName('Compra');
        $this->setClassName('\\Compra');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addColumn('ID_PROD', 'IdProd', 'VARCHAR', false, 10, null);
        $this->addPrimaryKey('ID_COMPRA', 'IdCompra', 'INTEGER', true, null, null);
        $this->addForeignKey('ID_FACTURA', 'IdFactura', 'INTEGER', 'factura', 'ID_FACTURA', false, 4, null);
        $this->addColumn('CANT_PROD', 'CantProd', 'INTEGER', true, null, null);
        $this->addColumn('VALOR', 'Valor', 'DECIMAL', true, null, null);
        $this->addColumn('IVA', 'Iva', 'TINYINT', true, null, null);
        $this->addColumn('PORCETAJE_RED', 'PorcetajeRed', 'SMALLINT', true, null, null);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('IdCompra', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('IdCompra', TableMap::TYPE_PHPNAME, $indexType)];
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
                            : self::translateFieldName('IdCompra', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? CompraTableMap::CLASS_DEFAULT : CompraTableMap::OM_CLASS;
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
     * @return array (Compra object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CompraTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CompraTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CompraTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CompraTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CompraTableMap::addInstanceToPool($obj, $key);
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
            $key = CompraTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CompraTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CompraTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(CompraTableMap::ID_PROD);
            $criteria->addSelectColumn(CompraTableMap::ID_COMPRA);
            $criteria->addSelectColumn(CompraTableMap::ID_FACTURA);
            $criteria->addSelectColumn(CompraTableMap::CANT_PROD);
            $criteria->addSelectColumn(CompraTableMap::VALOR);
            $criteria->addSelectColumn(CompraTableMap::IVA);
            $criteria->addSelectColumn(CompraTableMap::PORCETAJE_RED);
        } else {
            $criteria->addSelectColumn($alias . '.ID_PROD');
            $criteria->addSelectColumn($alias . '.ID_COMPRA');
            $criteria->addSelectColumn($alias . '.ID_FACTURA');
            $criteria->addSelectColumn($alias . '.CANT_PROD');
            $criteria->addSelectColumn($alias . '.VALOR');
            $criteria->addSelectColumn($alias . '.IVA');
            $criteria->addSelectColumn($alias . '.PORCETAJE_RED');
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
        return Propel::getServiceContainer()->getDatabaseMap(CompraTableMap::DATABASE_NAME)->getTable(CompraTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(CompraTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(CompraTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new CompraTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a Compra or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Compra object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CompraTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Compra) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CompraTableMap::DATABASE_NAME);
            $criteria->add(CompraTableMap::ID_COMPRA, (array) $values, Criteria::IN);
        }

        $query = CompraQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { CompraTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { CompraTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the compra table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CompraQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Compra or Criteria object.
     *
     * @param mixed               $criteria Criteria or Compra object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CompraTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Compra object
        }

        if ($criteria->containsKey(CompraTableMap::ID_COMPRA) && $criteria->keyContainsValue(CompraTableMap::ID_COMPRA) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CompraTableMap::ID_COMPRA.')');
        }


        // Set the correct dbName
        $query = CompraQuery::create()->mergeWith($criteria);

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

} // CompraTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CompraTableMap::buildTableMap();
