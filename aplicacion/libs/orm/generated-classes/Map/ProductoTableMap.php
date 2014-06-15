<?php

namespace Map;

use \Producto;
use \ProductoQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'producto' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ProductoTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ProductoTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'uvshop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'producto';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Producto';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Producto';

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
    const ID_PROD = 'producto.ID_PROD';

    /**
     * the column name for the NOMBRE field
     */
    const NOMBRE = 'producto.NOMBRE';

    /**
     * the column name for the EMPRESA_FAB field
     */
    const EMPRESA_FAB = 'producto.EMPRESA_FAB';

    /**
     * the column name for the DESCRIPCION field
     */
    const DESCRIPCION = 'producto.DESCRIPCION';

    /**
     * the column name for the IVA field
     */
    const IVA = 'producto.IVA';

    /**
     * the column name for the CATEGORIA field
     */
    const CATEGORIA = 'producto.CATEGORIA';

    /**
     * the column name for the UNIDADES field
     */
    const UNIDADES = 'producto.UNIDADES';

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
        self::TYPE_PHPNAME       => array('IdProd', 'Nombre', 'EmpresaFab', 'Descripcion', 'Iva', 'Categoria', 'Unidades', ),
        self::TYPE_STUDLYPHPNAME => array('idProd', 'nombre', 'empresaFab', 'descripcion', 'iva', 'categoria', 'unidades', ),
        self::TYPE_COLNAME       => array(ProductoTableMap::ID_PROD, ProductoTableMap::NOMBRE, ProductoTableMap::EMPRESA_FAB, ProductoTableMap::DESCRIPCION, ProductoTableMap::IVA, ProductoTableMap::CATEGORIA, ProductoTableMap::UNIDADES, ),
        self::TYPE_RAW_COLNAME   => array('ID_PROD', 'NOMBRE', 'EMPRESA_FAB', 'DESCRIPCION', 'IVA', 'CATEGORIA', 'UNIDADES', ),
        self::TYPE_FIELDNAME     => array('id_prod', 'nombre', 'empresa_fab', 'descripcion', 'iva', 'categoria', 'unidades', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdProd' => 0, 'Nombre' => 1, 'EmpresaFab' => 2, 'Descripcion' => 3, 'Iva' => 4, 'Categoria' => 5, 'Unidades' => 6, ),
        self::TYPE_STUDLYPHPNAME => array('idProd' => 0, 'nombre' => 1, 'empresaFab' => 2, 'descripcion' => 3, 'iva' => 4, 'categoria' => 5, 'unidades' => 6, ),
        self::TYPE_COLNAME       => array(ProductoTableMap::ID_PROD => 0, ProductoTableMap::NOMBRE => 1, ProductoTableMap::EMPRESA_FAB => 2, ProductoTableMap::DESCRIPCION => 3, ProductoTableMap::IVA => 4, ProductoTableMap::CATEGORIA => 5, ProductoTableMap::UNIDADES => 6, ),
        self::TYPE_RAW_COLNAME   => array('ID_PROD' => 0, 'NOMBRE' => 1, 'EMPRESA_FAB' => 2, 'DESCRIPCION' => 3, 'IVA' => 4, 'CATEGORIA' => 5, 'UNIDADES' => 6, ),
        self::TYPE_FIELDNAME     => array('id_prod' => 0, 'nombre' => 1, 'empresa_fab' => 2, 'descripcion' => 3, 'iva' => 4, 'categoria' => 5, 'unidades' => 6, ),
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
        $this->setName('producto');
        $this->setPhpName('Producto');
        $this->setClassName('\\Producto');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('ID_PROD', 'IdProd', 'VARCHAR', true, 10, '');
        $this->addColumn('NOMBRE', 'Nombre', 'VARCHAR', true, 30, null);
        $this->addColumn('EMPRESA_FAB', 'EmpresaFab', 'VARCHAR', true, 20, null);
        $this->addColumn('DESCRIPCION', 'Descripcion', 'LONGVARCHAR', true, null, null);
        $this->addColumn('IVA', 'Iva', 'TINYINT', true, null, null);
        $this->addColumn('CATEGORIA', 'Categoria', 'VARCHAR', false, 25, null);
        $this->addColumn('UNIDADES', 'Unidades', 'INTEGER', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Factura', '\\Factura', RelationMap::ONE_TO_MANY, array('id_prod' => 'id_cliente', ), 'CASCADE', null, 'Facturas');
        $this->addRelation('Imagen', '\\Imagen', RelationMap::ONE_TO_MANY, array('id_prod' => 'id_prod', ), 'CASCADE', null, 'Imagens');
        $this->addRelation('Precio', '\\Precio', RelationMap::ONE_TO_MANY, array('id_prod' => 'cod_producto', ), 'CASCADE', 'CASCADE', 'Precios');
        $this->addRelation('Promocion', '\\Promocion', RelationMap::ONE_TO_MANY, array('id_prod' => 'cod_producto', ), null, null, 'Promocions');
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to producto     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ".$this->getClassNameFromBuilder($joinedTableTableMapBuilder)." instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
                FacturaTableMap::clearInstancePool();
                ImagenTableMap::clearInstancePool();
                PrecioTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdProd', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdProd', TableMap::TYPE_PHPNAME, $indexType)];
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

            return (string) $row[
                            $indexType == TableMap::TYPE_NUM
                            ? 0 + $offset
                            : self::translateFieldName('IdProd', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? ProductoTableMap::CLASS_DEFAULT : ProductoTableMap::OM_CLASS;
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
     * @return array (Producto object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ProductoTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ProductoTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ProductoTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ProductoTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ProductoTableMap::addInstanceToPool($obj, $key);
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
            $key = ProductoTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ProductoTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ProductoTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ProductoTableMap::ID_PROD);
            $criteria->addSelectColumn(ProductoTableMap::NOMBRE);
            $criteria->addSelectColumn(ProductoTableMap::EMPRESA_FAB);
            $criteria->addSelectColumn(ProductoTableMap::DESCRIPCION);
            $criteria->addSelectColumn(ProductoTableMap::IVA);
            $criteria->addSelectColumn(ProductoTableMap::CATEGORIA);
            $criteria->addSelectColumn(ProductoTableMap::UNIDADES);
        } else {
            $criteria->addSelectColumn($alias . '.ID_PROD');
            $criteria->addSelectColumn($alias . '.NOMBRE');
            $criteria->addSelectColumn($alias . '.EMPRESA_FAB');
            $criteria->addSelectColumn($alias . '.DESCRIPCION');
            $criteria->addSelectColumn($alias . '.IVA');
            $criteria->addSelectColumn($alias . '.CATEGORIA');
            $criteria->addSelectColumn($alias . '.UNIDADES');
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
        return Propel::getServiceContainer()->getDatabaseMap(ProductoTableMap::DATABASE_NAME)->getTable(ProductoTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(ProductoTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(ProductoTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new ProductoTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a Producto or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Producto object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ProductoTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Producto) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ProductoTableMap::DATABASE_NAME);
            $criteria->add(ProductoTableMap::ID_PROD, (array) $values, Criteria::IN);
        }

        $query = ProductoQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { ProductoTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { ProductoTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the producto table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ProductoQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Producto or Criteria object.
     *
     * @param mixed               $criteria Criteria or Producto object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductoTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Producto object
        }


        // Set the correct dbName
        $query = ProductoQuery::create()->mergeWith($criteria);

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

} // ProductoTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ProductoTableMap::buildTableMap();
