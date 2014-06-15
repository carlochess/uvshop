<?php

namespace Map;

use \Factura;
use \FacturaQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'factura' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class FacturaTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.FacturaTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'uvshop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'factura';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Factura';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Factura';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the ID_FACTURA field
     */
    const ID_FACTURA = 'factura.ID_FACTURA';

    /**
     * the column name for the ID_CLIENTE field
     */
    const ID_CLIENTE = 'factura.ID_CLIENTE';

    /**
     * the column name for the FECHA field
     */
    const FECHA = 'factura.FECHA';

    /**
     * the column name for the CANTIDAD_PRODUCTOS field
     */
    const CANTIDAD_PRODUCTOS = 'factura.CANTIDAD_PRODUCTOS';

    /**
     * the column name for the VALOR field
     */
    const VALOR = 'factura.VALOR';

    /**
     * the column name for the IVA field
     */
    const IVA = 'factura.IVA';

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
        self::TYPE_PHPNAME       => array('IdFactura', 'IdCliente', 'Fecha', 'CantidadProductos', 'Valor', 'Iva', ),
        self::TYPE_STUDLYPHPNAME => array('idFactura', 'idCliente', 'fecha', 'cantidadProductos', 'valor', 'iva', ),
        self::TYPE_COLNAME       => array(FacturaTableMap::ID_FACTURA, FacturaTableMap::ID_CLIENTE, FacturaTableMap::FECHA, FacturaTableMap::CANTIDAD_PRODUCTOS, FacturaTableMap::VALOR, FacturaTableMap::IVA, ),
        self::TYPE_RAW_COLNAME   => array('ID_FACTURA', 'ID_CLIENTE', 'FECHA', 'CANTIDAD_PRODUCTOS', 'VALOR', 'IVA', ),
        self::TYPE_FIELDNAME     => array('id_factura', 'id_cliente', 'fecha', 'cantidad_productos', 'valor', 'iva', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdFactura' => 0, 'IdCliente' => 1, 'Fecha' => 2, 'CantidadProductos' => 3, 'Valor' => 4, 'Iva' => 5, ),
        self::TYPE_STUDLYPHPNAME => array('idFactura' => 0, 'idCliente' => 1, 'fecha' => 2, 'cantidadProductos' => 3, 'valor' => 4, 'iva' => 5, ),
        self::TYPE_COLNAME       => array(FacturaTableMap::ID_FACTURA => 0, FacturaTableMap::ID_CLIENTE => 1, FacturaTableMap::FECHA => 2, FacturaTableMap::CANTIDAD_PRODUCTOS => 3, FacturaTableMap::VALOR => 4, FacturaTableMap::IVA => 5, ),
        self::TYPE_RAW_COLNAME   => array('ID_FACTURA' => 0, 'ID_CLIENTE' => 1, 'FECHA' => 2, 'CANTIDAD_PRODUCTOS' => 3, 'VALOR' => 4, 'IVA' => 5, ),
        self::TYPE_FIELDNAME     => array('id_factura' => 0, 'id_cliente' => 1, 'fecha' => 2, 'cantidad_productos' => 3, 'valor' => 4, 'iva' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
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
        $this->setName('factura');
        $this->setPhpName('Factura');
        $this->setClassName('\\Factura');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID_FACTURA', 'IdFactura', 'INTEGER', true, 5, null);
        $this->addForeignKey('ID_CLIENTE', 'IdCliente', 'VARCHAR', 'producto', 'ID_PROD', true, 40, null);
        $this->addColumn('FECHA', 'Fecha', 'DATE', true, null, null);
        $this->addColumn('CANTIDAD_PRODUCTOS', 'CantidadProductos', 'INTEGER', true, null, null);
        $this->addColumn('VALOR', 'Valor', 'DECIMAL', true, null, null);
        $this->addColumn('IVA', 'Iva', 'TINYINT', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Producto', '\\Producto', RelationMap::MANY_TO_ONE, array('id_cliente' => 'id_prod', ), 'CASCADE', null);
        $this->addRelation('Compra', '\\Compra', RelationMap::ONE_TO_MANY, array('id_factura' => 'id_factura', ), 'CASCADE', null, 'Compras');
        $this->addRelation('MetodoPago', '\\MetodoPago', RelationMap::ONE_TO_MANY, array('id_factura' => 'id_factura', ), 'CASCADE', null, 'MetodoPagos');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to factura     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                CompraTableMap::clearInstancePool();
                MetodoPagoTableMap::clearInstancePool();
            }

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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdFactura', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdFactura', TableMap::TYPE_PHPNAME, $indexType)];
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
                            ? 0 + $offset
                            : self::translateFieldName('IdFactura', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? FacturaTableMap::CLASS_DEFAULT : FacturaTableMap::OM_CLASS;
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
     * @return array (Factura object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = FacturaTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = FacturaTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + FacturaTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = FacturaTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            FacturaTableMap::addInstanceToPool($obj, $key);
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
            $key = FacturaTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = FacturaTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                FacturaTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(FacturaTableMap::ID_FACTURA);
            $criteria->addSelectColumn(FacturaTableMap::ID_CLIENTE);
            $criteria->addSelectColumn(FacturaTableMap::FECHA);
            $criteria->addSelectColumn(FacturaTableMap::CANTIDAD_PRODUCTOS);
            $criteria->addSelectColumn(FacturaTableMap::VALOR);
            $criteria->addSelectColumn(FacturaTableMap::IVA);
        } else {
            $criteria->addSelectColumn($alias . '.ID_FACTURA');
            $criteria->addSelectColumn($alias . '.ID_CLIENTE');
            $criteria->addSelectColumn($alias . '.FECHA');
            $criteria->addSelectColumn($alias . '.CANTIDAD_PRODUCTOS');
            $criteria->addSelectColumn($alias . '.VALOR');
            $criteria->addSelectColumn($alias . '.IVA');
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
        return Propel::getServiceContainer()->getDatabaseMap(FacturaTableMap::DATABASE_NAME)->getTable(FacturaTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(FacturaTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(FacturaTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new FacturaTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a Factura or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Factura object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(FacturaTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Factura) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(FacturaTableMap::DATABASE_NAME);
            $criteria->add(FacturaTableMap::ID_FACTURA, (array) $values, Criteria::IN);
        }

        $query = FacturaQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { FacturaTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { FacturaTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the factura table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return FacturaQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Factura or Criteria object.
     *
     * @param mixed               $criteria Criteria or Factura object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FacturaTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Factura object
        }

        if ($criteria->containsKey(FacturaTableMap::ID_FACTURA) && $criteria->keyContainsValue(FacturaTableMap::ID_FACTURA) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.FacturaTableMap::ID_FACTURA.')');
        }


        // Set the correct dbName
        $query = FacturaQuery::create()->mergeWith($criteria);

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

} // FacturaTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
FacturaTableMap::buildTableMap();
