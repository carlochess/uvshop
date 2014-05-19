<?php

namespace Base;

use \Factura as ChildFactura;
use \FacturaQuery as ChildFacturaQuery;
use \Precio as ChildPrecio;
use \PrecioQuery as ChildPrecioQuery;
use \Producto as ChildProducto;
use \ProductoQuery as ChildProductoQuery;
use \Exception;
use \PDO;
use Map\ProductoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

abstract class Producto implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ProductoTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id_prod field.
     * Note: this column has a database default value of: ''
     * @var        string
     */
    protected $id_prod;

    /**
     * The value for the nombre field.
     * @var        string
     */
    protected $nombre;

    /**
     * The value for the empresa_fab field.
     * @var        string
     */
    protected $empresa_fab;

    /**
     * The value for the descripcion field.
     * @var        string
     */
    protected $descripcion;

    /**
     * The value for the iva field.
     * @var        int
     */
    protected $iva;

    /**
     * The value for the categoria field.
     * @var        string
     */
    protected $categoria;

    /**
     * The value for the unidades field.
     * @var        int
     */
    protected $unidades;

    /**
     * @var        ObjectCollection|ChildFactura[] Collection to store aggregation of ChildFactura objects.
     */
    protected $collFacturas;
    protected $collFacturasPartial;

    /**
     * @var        ObjectCollection|ChildPrecio[] Collection to store aggregation of ChildPrecio objects.
     */
    protected $collPrecios;
    protected $collPreciosPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $facturasScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection
     */
    protected $preciosScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->id_prod = '';
    }

    /**
     * Initializes internal state of Base\Producto object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !empty($this->modifiedColumns);
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return in_array($col, $this->modifiedColumns);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return array_unique($this->modifiedColumns);
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (Boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (Boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            while (false !== ($offset = array_search($col, $this->modifiedColumns))) {
                array_splice($this->modifiedColumns, $offset, 1);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Producto</code> instance.  If
     * <code>obj</code> is an instance of <code>Producto</code>, delegates to
     * <code>equals(Producto)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        $thisclazz = get_class($this);
        if (!is_object($obj) || !($obj instanceof $thisclazz)) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey()
            || null === $obj->getPrimaryKey())  {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        if (null !== $this->getPrimaryKey()) {
            return crc32(serialize($this->getPrimaryKey()));
        }

        return crc32(serialize(clone $this));
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return Producto The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     *
     * @return Producto The current object, for fluid interface
     */
    public function importFrom($parser, $data)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), TableMap::TYPE_PHPNAME);

        return $this;
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id_prod] column value.
     *
     * @return   string
     */
    public function getIdProd()
    {

        return $this->id_prod;
    }

    /**
     * Get the [nombre] column value.
     *
     * @return   string
     */
    public function getNombre()
    {

        return $this->nombre;
    }

    /**
     * Get the [empresa_fab] column value.
     *
     * @return   string
     */
    public function getEmpresaFab()
    {

        return $this->empresa_fab;
    }

    /**
     * Get the [descripcion] column value.
     *
     * @return   string
     */
    public function getDescripcion()
    {

        return $this->descripcion;
    }

    /**
     * Get the [iva] column value.
     *
     * @return   int
     */
    public function getIva()
    {

        return $this->iva;
    }

    /**
     * Get the [categoria] column value.
     *
     * @return   string
     */
    public function getCategoria()
    {

        return $this->categoria;
    }

    /**
     * Get the [unidades] column value.
     *
     * @return   int
     */
    public function getUnidades()
    {

        return $this->unidades;
    }

    /**
     * Set the value of [id_prod] column.
     *
     * @param      string $v new value
     * @return   \Producto The current object (for fluent API support)
     */
    public function setIdProd($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id_prod !== $v) {
            $this->id_prod = $v;
            $this->modifiedColumns[] = ProductoTableMap::ID_PROD;
        }


        return $this;
    } // setIdProd()

    /**
     * Set the value of [nombre] column.
     *
     * @param      string $v new value
     * @return   \Producto The current object (for fluent API support)
     */
    public function setNombre($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nombre !== $v) {
            $this->nombre = $v;
            $this->modifiedColumns[] = ProductoTableMap::NOMBRE;
        }


        return $this;
    } // setNombre()

    /**
     * Set the value of [empresa_fab] column.
     *
     * @param      string $v new value
     * @return   \Producto The current object (for fluent API support)
     */
    public function setEmpresaFab($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->empresa_fab !== $v) {
            $this->empresa_fab = $v;
            $this->modifiedColumns[] = ProductoTableMap::EMPRESA_FAB;
        }


        return $this;
    } // setEmpresaFab()

    /**
     * Set the value of [descripcion] column.
     *
     * @param      string $v new value
     * @return   \Producto The current object (for fluent API support)
     */
    public function setDescripcion($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->descripcion !== $v) {
            $this->descripcion = $v;
            $this->modifiedColumns[] = ProductoTableMap::DESCRIPCION;
        }


        return $this;
    } // setDescripcion()

    /**
     * Set the value of [iva] column.
     *
     * @param      int $v new value
     * @return   \Producto The current object (for fluent API support)
     */
    public function setIva($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->iva !== $v) {
            $this->iva = $v;
            $this->modifiedColumns[] = ProductoTableMap::IVA;
        }


        return $this;
    } // setIva()

    /**
     * Set the value of [categoria] column.
     *
     * @param      string $v new value
     * @return   \Producto The current object (for fluent API support)
     */
    public function setCategoria($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->categoria !== $v) {
            $this->categoria = $v;
            $this->modifiedColumns[] = ProductoTableMap::CATEGORIA;
        }


        return $this;
    } // setCategoria()

    /**
     * Set the value of [unidades] column.
     *
     * @param      int $v new value
     * @return   \Producto The current object (for fluent API support)
     */
    public function setUnidades($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->unidades !== $v) {
            $this->unidades = $v;
            $this->modifiedColumns[] = ProductoTableMap::UNIDADES;
        }


        return $this;
    } // setUnidades()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->id_prod !== '') {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ProductoTableMap::translateFieldName('IdProd', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_prod = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ProductoTableMap::translateFieldName('Nombre', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nombre = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ProductoTableMap::translateFieldName('EmpresaFab', TableMap::TYPE_PHPNAME, $indexType)];
            $this->empresa_fab = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ProductoTableMap::translateFieldName('Descripcion', TableMap::TYPE_PHPNAME, $indexType)];
            $this->descripcion = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ProductoTableMap::translateFieldName('Iva', TableMap::TYPE_PHPNAME, $indexType)];
            $this->iva = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ProductoTableMap::translateFieldName('Categoria', TableMap::TYPE_PHPNAME, $indexType)];
            $this->categoria = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ProductoTableMap::translateFieldName('Unidades', TableMap::TYPE_PHPNAME, $indexType)];
            $this->unidades = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = ProductoTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \Producto object", 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProductoTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildProductoQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collFacturas = null;

            $this->collPrecios = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Producto::setDeleted()
     * @see Producto::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductoTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildProductoQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductoTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ProductoTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->facturasScheduledForDeletion !== null) {
                if (!$this->facturasScheduledForDeletion->isEmpty()) {
                    \FacturaQuery::create()
                        ->filterByPrimaryKeys($this->facturasScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->facturasScheduledForDeletion = null;
                }
            }

                if ($this->collFacturas !== null) {
            foreach ($this->collFacturas as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->preciosScheduledForDeletion !== null) {
                if (!$this->preciosScheduledForDeletion->isEmpty()) {
                    \PrecioQuery::create()
                        ->filterByPrimaryKeys($this->preciosScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->preciosScheduledForDeletion = null;
                }
            }

                if ($this->collPrecios !== null) {
            foreach ($this->collPrecios as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProductoTableMap::ID_PROD)) {
            $modifiedColumns[':p' . $index++]  = 'ID_PROD';
        }
        if ($this->isColumnModified(ProductoTableMap::NOMBRE)) {
            $modifiedColumns[':p' . $index++]  = 'NOMBRE';
        }
        if ($this->isColumnModified(ProductoTableMap::EMPRESA_FAB)) {
            $modifiedColumns[':p' . $index++]  = 'EMPRESA_FAB';
        }
        if ($this->isColumnModified(ProductoTableMap::DESCRIPCION)) {
            $modifiedColumns[':p' . $index++]  = 'DESCRIPCION';
        }
        if ($this->isColumnModified(ProductoTableMap::IVA)) {
            $modifiedColumns[':p' . $index++]  = 'IVA';
        }
        if ($this->isColumnModified(ProductoTableMap::CATEGORIA)) {
            $modifiedColumns[':p' . $index++]  = 'CATEGORIA';
        }
        if ($this->isColumnModified(ProductoTableMap::UNIDADES)) {
            $modifiedColumns[':p' . $index++]  = 'UNIDADES';
        }

        $sql = sprintf(
            'INSERT INTO producto (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ID_PROD':
                        $stmt->bindValue($identifier, $this->id_prod, PDO::PARAM_STR);
                        break;
                    case 'NOMBRE':
                        $stmt->bindValue($identifier, $this->nombre, PDO::PARAM_STR);
                        break;
                    case 'EMPRESA_FAB':
                        $stmt->bindValue($identifier, $this->empresa_fab, PDO::PARAM_STR);
                        break;
                    case 'DESCRIPCION':
                        $stmt->bindValue($identifier, $this->descripcion, PDO::PARAM_STR);
                        break;
                    case 'IVA':
                        $stmt->bindValue($identifier, $this->iva, PDO::PARAM_INT);
                        break;
                    case 'CATEGORIA':
                        $stmt->bindValue($identifier, $this->categoria, PDO::PARAM_STR);
                        break;
                    case 'UNIDADES':
                        $stmt->bindValue($identifier, $this->unidades, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ProductoTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getIdProd();
                break;
            case 1:
                return $this->getNombre();
                break;
            case 2:
                return $this->getEmpresaFab();
                break;
            case 3:
                return $this->getDescripcion();
                break;
            case 4:
                return $this->getIva();
                break;
            case 5:
                return $this->getCategoria();
                break;
            case 6:
                return $this->getUnidades();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Producto'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Producto'][$this->getPrimaryKey()] = true;
        $keys = ProductoTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdProd(),
            $keys[1] => $this->getNombre(),
            $keys[2] => $this->getEmpresaFab(),
            $keys[3] => $this->getDescripcion(),
            $keys[4] => $this->getIva(),
            $keys[5] => $this->getCategoria(),
            $keys[6] => $this->getUnidades(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collFacturas) {
                $result['Facturas'] = $this->collFacturas->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPrecios) {
                $result['Precios'] = $this->collPrecios->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param      string $name
     * @param      mixed  $value field value
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return void
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ProductoTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @param      mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setIdProd($value);
                break;
            case 1:
                $this->setNombre($value);
                break;
            case 2:
                $this->setEmpresaFab($value);
                break;
            case 3:
                $this->setDescripcion($value);
                break;
            case 4:
                $this->setIva($value);
                break;
            case 5:
                $this->setCategoria($value);
                break;
            case 6:
                $this->setUnidades($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_STUDLYPHPNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = ProductoTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdProd($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setNombre($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setEmpresaFab($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setDescripcion($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setIva($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setCategoria($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setUnidades($arr[$keys[6]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ProductoTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ProductoTableMap::ID_PROD)) $criteria->add(ProductoTableMap::ID_PROD, $this->id_prod);
        if ($this->isColumnModified(ProductoTableMap::NOMBRE)) $criteria->add(ProductoTableMap::NOMBRE, $this->nombre);
        if ($this->isColumnModified(ProductoTableMap::EMPRESA_FAB)) $criteria->add(ProductoTableMap::EMPRESA_FAB, $this->empresa_fab);
        if ($this->isColumnModified(ProductoTableMap::DESCRIPCION)) $criteria->add(ProductoTableMap::DESCRIPCION, $this->descripcion);
        if ($this->isColumnModified(ProductoTableMap::IVA)) $criteria->add(ProductoTableMap::IVA, $this->iva);
        if ($this->isColumnModified(ProductoTableMap::CATEGORIA)) $criteria->add(ProductoTableMap::CATEGORIA, $this->categoria);
        if ($this->isColumnModified(ProductoTableMap::UNIDADES)) $criteria->add(ProductoTableMap::UNIDADES, $this->unidades);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(ProductoTableMap::DATABASE_NAME);
        $criteria->add(ProductoTableMap::ID_PROD, $this->id_prod);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return   string
     */
    public function getPrimaryKey()
    {
        return $this->getIdProd();
    }

    /**
     * Generic method to set the primary key (id_prod column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdProd($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdProd();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Producto (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setIdProd($this->getIdProd());
        $copyObj->setNombre($this->getNombre());
        $copyObj->setEmpresaFab($this->getEmpresaFab());
        $copyObj->setDescripcion($this->getDescripcion());
        $copyObj->setIva($this->getIva());
        $copyObj->setCategoria($this->getCategoria());
        $copyObj->setUnidades($this->getUnidades());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getFacturas() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFactura($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPrecios() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPrecio($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return                 \Producto Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Factura' == $relationName) {
            return $this->initFacturas();
        }
        if ('Precio' == $relationName) {
            return $this->initPrecios();
        }
    }

    /**
     * Clears out the collFacturas collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addFacturas()
     */
    public function clearFacturas()
    {
        $this->collFacturas = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collFacturas collection loaded partially.
     */
    public function resetPartialFacturas($v = true)
    {
        $this->collFacturasPartial = $v;
    }

    /**
     * Initializes the collFacturas collection.
     *
     * By default this just sets the collFacturas collection to an empty array (like clearcollFacturas());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFacturas($overrideExisting = true)
    {
        if (null !== $this->collFacturas && !$overrideExisting) {
            return;
        }
        $this->collFacturas = new ObjectCollection();
        $this->collFacturas->setModel('\Factura');
    }

    /**
     * Gets an array of ChildFactura objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProducto is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildFactura[] List of ChildFactura objects
     * @throws PropelException
     */
    public function getFacturas($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collFacturasPartial && !$this->isNew();
        if (null === $this->collFacturas || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFacturas) {
                // return empty collection
                $this->initFacturas();
            } else {
                $collFacturas = ChildFacturaQuery::create(null, $criteria)
                    ->filterByProducto($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collFacturasPartial && count($collFacturas)) {
                        $this->initFacturas(false);

                        foreach ($collFacturas as $obj) {
                            if (false == $this->collFacturas->contains($obj)) {
                                $this->collFacturas->append($obj);
                            }
                        }

                        $this->collFacturasPartial = true;
                    }

                    $collFacturas->getInternalIterator()->rewind();

                    return $collFacturas;
                }

                if ($partial && $this->collFacturas) {
                    foreach ($this->collFacturas as $obj) {
                        if ($obj->isNew()) {
                            $collFacturas[] = $obj;
                        }
                    }
                }

                $this->collFacturas = $collFacturas;
                $this->collFacturasPartial = false;
            }
        }

        return $this->collFacturas;
    }

    /**
     * Sets a collection of Factura objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $facturas A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildProducto The current object (for fluent API support)
     */
    public function setFacturas(Collection $facturas, ConnectionInterface $con = null)
    {
        $facturasToDelete = $this->getFacturas(new Criteria(), $con)->diff($facturas);


        $this->facturasScheduledForDeletion = $facturasToDelete;

        foreach ($facturasToDelete as $facturaRemoved) {
            $facturaRemoved->setProducto(null);
        }

        $this->collFacturas = null;
        foreach ($facturas as $factura) {
            $this->addFactura($factura);
        }

        $this->collFacturas = $facturas;
        $this->collFacturasPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Factura objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Factura objects.
     * @throws PropelException
     */
    public function countFacturas(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collFacturasPartial && !$this->isNew();
        if (null === $this->collFacturas || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFacturas) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getFacturas());
            }

            $query = ChildFacturaQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProducto($this)
                ->count($con);
        }

        return count($this->collFacturas);
    }

    /**
     * Method called to associate a ChildFactura object to this object
     * through the ChildFactura foreign key attribute.
     *
     * @param    ChildFactura $l ChildFactura
     * @return   \Producto The current object (for fluent API support)
     */
    public function addFactura(ChildFactura $l)
    {
        if ($this->collFacturas === null) {
            $this->initFacturas();
            $this->collFacturasPartial = true;
        }

        if (!in_array($l, $this->collFacturas->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFactura($l);
        }

        return $this;
    }

    /**
     * @param Factura $factura The factura object to add.
     */
    protected function doAddFactura($factura)
    {
        $this->collFacturas[]= $factura;
        $factura->setProducto($this);
    }

    /**
     * @param  Factura $factura The factura object to remove.
     * @return ChildProducto The current object (for fluent API support)
     */
    public function removeFactura($factura)
    {
        if ($this->getFacturas()->contains($factura)) {
            $this->collFacturas->remove($this->collFacturas->search($factura));
            if (null === $this->facturasScheduledForDeletion) {
                $this->facturasScheduledForDeletion = clone $this->collFacturas;
                $this->facturasScheduledForDeletion->clear();
            }
            $this->facturasScheduledForDeletion[]= clone $factura;
            $factura->setProducto(null);
        }

        return $this;
    }

    /**
     * Clears out the collPrecios collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPrecios()
     */
    public function clearPrecios()
    {
        $this->collPrecios = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPrecios collection loaded partially.
     */
    public function resetPartialPrecios($v = true)
    {
        $this->collPreciosPartial = $v;
    }

    /**
     * Initializes the collPrecios collection.
     *
     * By default this just sets the collPrecios collection to an empty array (like clearcollPrecios());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPrecios($overrideExisting = true)
    {
        if (null !== $this->collPrecios && !$overrideExisting) {
            return;
        }
        $this->collPrecios = new ObjectCollection();
        $this->collPrecios->setModel('\Precio');
    }

    /**
     * Gets an array of ChildPrecio objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildProducto is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return Collection|ChildPrecio[] List of ChildPrecio objects
     * @throws PropelException
     */
    public function getPrecios($criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPreciosPartial && !$this->isNew();
        if (null === $this->collPrecios || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPrecios) {
                // return empty collection
                $this->initPrecios();
            } else {
                $collPrecios = ChildPrecioQuery::create(null, $criteria)
                    ->filterByProducto($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPreciosPartial && count($collPrecios)) {
                        $this->initPrecios(false);

                        foreach ($collPrecios as $obj) {
                            if (false == $this->collPrecios->contains($obj)) {
                                $this->collPrecios->append($obj);
                            }
                        }

                        $this->collPreciosPartial = true;
                    }

                    $collPrecios->getInternalIterator()->rewind();

                    return $collPrecios;
                }

                if ($partial && $this->collPrecios) {
                    foreach ($this->collPrecios as $obj) {
                        if ($obj->isNew()) {
                            $collPrecios[] = $obj;
                        }
                    }
                }

                $this->collPrecios = $collPrecios;
                $this->collPreciosPartial = false;
            }
        }

        return $this->collPrecios;
    }

    /**
     * Sets a collection of Precio objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $precios A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return   ChildProducto The current object (for fluent API support)
     */
    public function setPrecios(Collection $precios, ConnectionInterface $con = null)
    {
        $preciosToDelete = $this->getPrecios(new Criteria(), $con)->diff($precios);


        $this->preciosScheduledForDeletion = $preciosToDelete;

        foreach ($preciosToDelete as $precioRemoved) {
            $precioRemoved->setProducto(null);
        }

        $this->collPrecios = null;
        foreach ($precios as $precio) {
            $this->addPrecio($precio);
        }

        $this->collPrecios = $precios;
        $this->collPreciosPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Precio objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Precio objects.
     * @throws PropelException
     */
    public function countPrecios(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPreciosPartial && !$this->isNew();
        if (null === $this->collPrecios || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPrecios) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPrecios());
            }

            $query = ChildPrecioQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProducto($this)
                ->count($con);
        }

        return count($this->collPrecios);
    }

    /**
     * Method called to associate a ChildPrecio object to this object
     * through the ChildPrecio foreign key attribute.
     *
     * @param    ChildPrecio $l ChildPrecio
     * @return   \Producto The current object (for fluent API support)
     */
    public function addPrecio(ChildPrecio $l)
    {
        if ($this->collPrecios === null) {
            $this->initPrecios();
            $this->collPreciosPartial = true;
        }

        if (!in_array($l, $this->collPrecios->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPrecio($l);
        }

        return $this;
    }

    /**
     * @param Precio $precio The precio object to add.
     */
    protected function doAddPrecio($precio)
    {
        $this->collPrecios[]= $precio;
        $precio->setProducto($this);
    }

    /**
     * @param  Precio $precio The precio object to remove.
     * @return ChildProducto The current object (for fluent API support)
     */
    public function removePrecio($precio)
    {
        if ($this->getPrecios()->contains($precio)) {
            $this->collPrecios->remove($this->collPrecios->search($precio));
            if (null === $this->preciosScheduledForDeletion) {
                $this->preciosScheduledForDeletion = clone $this->collPrecios;
                $this->preciosScheduledForDeletion->clear();
            }
            $this->preciosScheduledForDeletion[]= $precio;
            $precio->setProducto(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_prod = null;
        $this->nombre = null;
        $this->empresa_fab = null;
        $this->descripcion = null;
        $this->iva = null;
        $this->categoria = null;
        $this->unidades = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collFacturas) {
                foreach ($this->collFacturas as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPrecios) {
                foreach ($this->collPrecios as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        if ($this->collFacturas instanceof Collection) {
            $this->collFacturas->clearIterator();
        }
        $this->collFacturas = null;
        if ($this->collPrecios instanceof Collection) {
            $this->collPrecios->clearIterator();
        }
        $this->collPrecios = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ProductoTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
