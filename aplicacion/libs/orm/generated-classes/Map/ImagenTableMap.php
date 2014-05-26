<?php

namespace Map;

use \Imagen;
use \ImagenQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'imagen' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ImagenTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;
    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ImagenTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'uvshop';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'imagen';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Imagen';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Imagen';

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
     * the column name for the ID_IMAGEN field
     */
    const ID_IMAGEN = 'imagen.ID_IMAGEN';

    /**
     * the column name for the ID_PROD field
     */
    const ID_PROD = 'imagen.ID_PROD';

    /**
     * the column name for the RUTA field
     */
    const RUTA = 'imagen.RUTA';

    /**
     * the column name for the ANCHO field
     */
    const ANCHO = 'imagen.ANCHO';

    /**
     * the column name for the LARGO field
     */
    const LARGO = 'imagen.LARGO';

    /**
     * the column name for the EXTENSION field
     */
    const EXTENSION = 'imagen.EXTENSION';

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
        self::TYPE_PHPNAME       => array('IdImagen', 'IdProd', 'Ruta', 'Ancho', 'Largo', 'Extension', ),
        self::TYPE_STUDLYPHPNAME => array('idImagen', 'idProd', 'ruta', 'ancho', 'largo', 'extension', ),
        self::TYPE_COLNAME       => array(ImagenTableMap::ID_IMAGEN, ImagenTableMap::ID_PROD, ImagenTableMap::RUTA, ImagenTableMap::ANCHO, ImagenTableMap::LARGO, ImagenTableMap::EXTENSION, ),
        self::TYPE_RAW_COLNAME   => array('ID_IMAGEN', 'ID_PROD', 'RUTA', 'ANCHO', 'LARGO', 'EXTENSION', ),
        self::TYPE_FIELDNAME     => array('id_imagen', 'id_prod', 'ruta', 'ancho', 'largo', 'extension', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdImagen' => 0, 'IdProd' => 1, 'Ruta' => 2, 'Ancho' => 3, 'Largo' => 4, 'Extension' => 5, ),
        self::TYPE_STUDLYPHPNAME => array('idImagen' => 0, 'idProd' => 1, 'ruta' => 2, 'ancho' => 3, 'largo' => 4, 'extension' => 5, ),
        self::TYPE_COLNAME       => array(ImagenTableMap::ID_IMAGEN => 0, ImagenTableMap::ID_PROD => 1, ImagenTableMap::RUTA => 2, ImagenTableMap::ANCHO => 3, ImagenTableMap::LARGO => 4, ImagenTableMap::EXTENSION => 5, ),
        self::TYPE_RAW_COLNAME   => array('ID_IMAGEN' => 0, 'ID_PROD' => 1, 'RUTA' => 2, 'ANCHO' => 3, 'LARGO' => 4, 'EXTENSION' => 5, ),
        self::TYPE_FIELDNAME     => array('id_imagen' => 0, 'id_prod' => 1, 'ruta' => 2, 'ancho' => 3, 'largo' => 4, 'extension' => 5, ),
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
        $this->setName('imagen');
        $this->setPhpName('Imagen');
        $this->setClassName('\\Imagen');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID_IMAGEN', 'IdImagen', 'INTEGER', true, null, null);
        $this->addForeignKey('ID_PROD', 'IdProd', 'VARCHAR', 'producto', 'ID_PROD', true, 10, null);
        $this->addColumn('RUTA', 'Ruta', 'VARCHAR', true, 40, null);
        $this->addColumn('ANCHO', 'Ancho', 'INTEGER', true, null, null);
        $this->addColumn('LARGO', 'Largo', 'INTEGER', true, null, null);
        $this->addColumn('EXTENSION', 'Extension', 'VARCHAR', true, 6, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Producto', '\\Producto', RelationMap::MANY_TO_ONE, array('id_prod' => 'id_prod', ), 'CASCADE', null);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdImagen', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdImagen', TableMap::TYPE_PHPNAME, $indexType)];
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
                            : self::translateFieldName('IdImagen', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? ImagenTableMap::CLASS_DEFAULT : ImagenTableMap::OM_CLASS;
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
     * @return array (Imagen object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ImagenTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ImagenTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ImagenTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ImagenTableMap::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ImagenTableMap::addInstanceToPool($obj, $key);
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
            $key = ImagenTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ImagenTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ImagenTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ImagenTableMap::ID_IMAGEN);
            $criteria->addSelectColumn(ImagenTableMap::ID_PROD);
            $criteria->addSelectColumn(ImagenTableMap::RUTA);
            $criteria->addSelectColumn(ImagenTableMap::ANCHO);
            $criteria->addSelectColumn(ImagenTableMap::LARGO);
            $criteria->addSelectColumn(ImagenTableMap::EXTENSION);
        } else {
            $criteria->addSelectColumn($alias . '.ID_IMAGEN');
            $criteria->addSelectColumn($alias . '.ID_PROD');
            $criteria->addSelectColumn($alias . '.RUTA');
            $criteria->addSelectColumn($alias . '.ANCHO');
            $criteria->addSelectColumn($alias . '.LARGO');
            $criteria->addSelectColumn($alias . '.EXTENSION');
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
        return Propel::getServiceContainer()->getDatabaseMap(ImagenTableMap::DATABASE_NAME)->getTable(ImagenTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getServiceContainer()->getDatabaseMap(ImagenTableMap::DATABASE_NAME);
      if (!$dbMap->hasTable(ImagenTableMap::TABLE_NAME)) {
        $dbMap->addTableObject(new ImagenTableMap());
      }
    }

    /**
     * Performs a DELETE on the database, given a Imagen or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Imagen object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ImagenTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Imagen) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ImagenTableMap::DATABASE_NAME);
            $criteria->add(ImagenTableMap::ID_IMAGEN, (array) $values, Criteria::IN);
        }

        $query = ImagenQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) { ImagenTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) { ImagenTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the imagen table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ImagenQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Imagen or Criteria object.
     *
     * @param mixed               $criteria Criteria or Imagen object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ImagenTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Imagen object
        }

        if ($criteria->containsKey(ImagenTableMap::ID_IMAGEN) && $criteria->keyContainsValue(ImagenTableMap::ID_IMAGEN) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ImagenTableMap::ID_IMAGEN.')');
        }


        // Set the correct dbName
        $query = ImagenQuery::create()->mergeWith($criteria);

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

} // ImagenTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ImagenTableMap::buildTableMap();
