<?php

namespace Map;

use \Precio;
use \PrecioQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'precio' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PrecioTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PrecioTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'uvshop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'precio';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Precio';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Precio';

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
     * the column name for the ID_PRECIO field
     */
    const ID_PRECIO = 'precio.ID_PRECIO';

    /**
     * the column name for the COD_PRODUCTO field
     */
    const COD_PRODUCTO = 'precio.COD_PRODUCTO';

    /**
     * the column name for the FECHA_INI field
     */
    const FECHA_INI = 'precio.FECHA_INI';

    /**
     * the column name for the FECHA_FIN field
     */
    const FECHA_FIN = 'precio.FECHA_FIN';

    /**
     * the column name for the VALOR field
     */
    const VALOR = 'precio.VALOR';

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
        self::TYPE_PHPNAME       => array('IdPrecio', 'CodProducto', 'FechaIni', 'FechaFin', 'Valor', ),
        self::TYPE_STUDLYPHPNAME => array('idPrecio', 'codProducto', 'fechaIni', 'fechaFin', 'valor', ),
        self::TYPE_COLNAME       => array(PrecioTableMap::ID_PRECIO, PrecioTableMap::COD_PRODUCTO, PrecioTableMap::FECHA_INI, PrecioTableMap::FECHA_FIN, PrecioTableMap::VALOR, ),
        self::TYPE_RAW_COLNAME   => array('ID_PRECIO', 'COD_PRODUCTO', 'FECHA_INI', 'FECHA_FIN', 'VALOR', ),
        self::TYPE_FIELDNAME     => array('id_precio', 'cod_producto', 'fecha_ini', 'fecha_fin', 'valor', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdPrecio' => 0, 'CodProducto' => 1, 'FechaIni' => 2, 'FechaFin' => 3, 'Valor' => 4, ),
        self::TYPE_STUDLYPHPNAME => array('idPrecio' => 0, 'codProducto' => 1, 'fechaIni' => 2, 'fechaFin' => 3, 'valor' => 4, ),
        self::TYPE_COLNAME       => array(PrecioTableMap::ID_PRECIO => 0, PrecioTableMap::COD_PRODUCTO => 1, PrecioTableMap::FECHA_INI => 2, PrecioTableMap::FECHA_FIN => 3, PrecioTableMap::VALOR => 4, ),
        self::TYPE_RAW_COLNAME   => array('ID_PRECIO' => 0, 'COD_PRODUCTO' => 1, 'FECHA_INI' => 2, 'FECHA_FIN' => 3, 'VALOR' => 4, ),
        self::TYPE_FIELDNAME     => array('id_precio' => 0, 'cod_producto' => 1, 'fecha_ini' => 2, 'fecha_fin' => 3, 'valor' => 4, ),
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
        $this->setName('precio');
        $this->setPhpName('Precio');
        $this->setClassName('\\Precio');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID_PRECIO', 'IdPrecio', 'INTEGER', true, null, null);
        $this->addForeignKey('COD_PRODUCTO', 'CodProducto', 'VARCHAR', 'producto', 'ID_PROD', false, 20, null);
        $this->addColumn('FECHA_INI', 'FechaIni', 'DATE', true, null, null);
        $this->addColumn('FECHA_FIN', 'FechaFin', 'DATE', true, null, null);
        $this->addColumn('VALOR', 'Valor', 'DECIMAL', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Producto', '\\Producto', RelationMap::MANY_TO_ONE, array('cod_producto' => 'id_prod', ), 'CASCADE', 'CASCADE');
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdPrecio', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdPrecio', TableMap::TYPE_PHPNAME, $indexType)];
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
                            : self::translateFieldName('IdPrecio', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? PrecioTableMap::CLASS_DEFAULT : PrecioTableMap::OM_CLASS;
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
     * @return array (Precio object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PrecioTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PrecioTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PrecioTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PrecioTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PrecioTableMap::addInstanceToPool($obj, $key);
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
            $key = PrecioTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PrecioTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PrecioTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PrecioTableMap::ID_PRECIO);
            $criteria->addSelectColumn(PrecioTableMap::COD_PRODUCTO);
            $criteria->addSelectColumn(PrecioTableMap::FECHA_INI);
            $criteria->addSelectColumn(PrecioTableMap::FECHA_FIN);
            $criteria->addSelectColumn(PrecioTableMap::VALOR);
        } else {
            $criteria->addSelectColumn($alias . '.ID_PRECIO');
            $criteria->addSelectColumn($alias . '.COD_PRODUCTO');
            $criteria->addSelectColumn($alias . '.FECHA_INI');
            $criteria->addSelectColumn($alias . '.FECHA_FIN');
            $criteria->addSelectColumn($alias . '.VALOR');
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
        return Propel::getServiceContainer()->getDatabaseMap(PrecioTableMap::DATABASE_NAME)->getTable(PrecioTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(PrecioTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(PrecioTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new PrecioTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a Precio or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Precio object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PrecioTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Precio) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PrecioTableMap::DATABASE_NAME);
            $criteria->add(PrecioTableMap::ID_PRECIO, (array) $values, Criteria::IN);
        }

        $query = PrecioQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { PrecioTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { PrecioTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the precio table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PrecioQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Precio or Criteria object.
     *
     * @param mixed               $criteria Criteria or Precio object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PrecioTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Precio object
        }

        if ($criteria->containsKey(PrecioTableMap::ID_PRECIO) && $criteria->keyContainsValue(PrecioTableMap::ID_PRECIO) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PrecioTableMap::ID_PRECIO.')');
        }


        // Set the correct dbName
        $query = PrecioQuery::create()->mergeWith($criteria);

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

} // PrecioTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PrecioTableMap::buildTableMap();
