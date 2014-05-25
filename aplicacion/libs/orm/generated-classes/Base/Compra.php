<?php

namespace Base;

use \CompraQuery as ChildCompraQuery;
use \Factura as ChildFactura;
use \FacturaQuery as ChildFacturaQuery;
use \Exception;
use \PDO;
use Map\CompraTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

abstract class Compra implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\CompraTableMap';


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
     * @var        string
     */
    protected $id_prod;

    /**
     * The value for the id_compra field.
     * @var        int
     */
    protected $id_compra;

    /**
     * The value for the id_factura field.
     * @var        int
     */
    protected $id_factura;

    /**
     * The value for the cant_prod field.
     * @var        int
     */
    protected $cant_prod;

    /**
     * The value for the valor field.
     * @var        string
     */
    protected $valor;

    /**
     * The value for the iva field.
     * @var        int
     */
    protected $iva;

    /**
     * The value for the porcetaje_red field.
     * @var        int
     */
    protected $porcetaje_red;

    /**
     * @var        Factura
     */
    protected $aFactura;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Initializes internal state of Base\Compra object.
     */
    public function __construct()
    {
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
     * Compares this with another <code>Compra</code> instance.  If
     * <code>obj</code> is an instance of <code>Compra</code>, delegates to
     * <code>equals(Compra)</code>.  Otherwise, returns <code>false</code>.
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
     * @return Compra The current object, for fluid interface
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
     * @return Compra The current object, for fluid interface
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
     * Get the [id_compra] column value.
     *
     * @return   int
     */
    public function getIdCompra()
    {

        return $this->id_compra;
    }

    /**
     * Get the [id_factura] column value.
     *
     * @return   int
     */
    public function getIdFactura()
    {

        return $this->id_factura;
    }

    /**
     * Get the [cant_prod] column value.
     *
     * @return   int
     */
    public function getCantProd()
    {

        return $this->cant_prod;
    }

    /**
     * Get the [valor] column value.
     *
     * @return   string
     */
    public function getValor()
    {

        return $this->valor;
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
     * Get the [porcetaje_red] column value.
     *
     * @return   int
     */
    public function getPorcetajeRed()
    {

        return $this->porcetaje_red;
    }

    /**
     * Set the value of [id_prod] column.
     *
     * @param      string $v new value
     * @return   \Compra The current object (for fluent API support)
     */
    public function setIdProd($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id_prod !== $v) {
            $this->id_prod = $v;
            $this->modifiedColumns[] = CompraTableMap::ID_PROD;
        }


        return $this;
    } // setIdProd()

    /**
     * Set the value of [id_compra] column.
     *
     * @param      int $v new value
     * @return   \Compra The current object (for fluent API support)
     */
    public function setIdCompra($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_compra !== $v) {
            $this->id_compra = $v;
            $this->modifiedColumns[] = CompraTableMap::ID_COMPRA;
        }


        return $this;
    } // setIdCompra()

    /**
     * Set the value of [id_factura] column.
     *
     * @param      int $v new value
     * @return   \Compra The current object (for fluent API support)
     */
    public function setIdFactura($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_factura !== $v) {
            $this->id_factura = $v;
            $this->modifiedColumns[] = CompraTableMap::ID_FACTURA;
        }

        if ($this->aFactura !== null && $this->aFactura->getIdFactura() !== $v) {
            $this->aFactura = null;
        }


        return $this;
    } // setIdFactura()

    /**
     * Set the value of [cant_prod] column.
     *
     * @param      int $v new value
     * @return   \Compra The current object (for fluent API support)
     */
    public function setCantProd($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->cant_prod !== $v) {
            $this->cant_prod = $v;
            $this->modifiedColumns[] = CompraTableMap::CANT_PROD;
        }


        return $this;
    } // setCantProd()

    /**
     * Set the value of [valor] column.
     *
     * @param      string $v new value
     * @return   \Compra The current object (for fluent API support)
     */
    public function setValor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->valor !== $v) {
            $this->valor = $v;
            $this->modifiedColumns[] = CompraTableMap::VALOR;
        }


        return $this;
    } // setValor()

    /**
     * Set the value of [iva] column.
     *
     * @param      int $v new value
     * @return   \Compra The current object (for fluent API support)
     */
    public function setIva($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->iva !== $v) {
            $this->iva = $v;
            $this->modifiedColumns[] = CompraTableMap::IVA;
        }


        return $this;
    } // setIva()

    /**
     * Set the value of [porcetaje_red] column.
     *
     * @param      int $v new value
     * @return   \Compra The current object (for fluent API support)
     */
    public function setPorcetajeRed($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->porcetaje_red !== $v) {
            $this->porcetaje_red = $v;
            $this->modifiedColumns[] = CompraTableMap::PORCETAJE_RED;
        }


        return $this;
    } // setPorcetajeRed()

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


            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : CompraTableMap::translateFieldName('IdProd', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_prod = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : CompraTableMap::translateFieldName('IdCompra', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_compra = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : CompraTableMap::translateFieldName('IdFactura', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_factura = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : CompraTableMap::translateFieldName('CantProd', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cant_prod = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : CompraTableMap::translateFieldName('Valor', TableMap::TYPE_PHPNAME, $indexType)];
            $this->valor = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : CompraTableMap::translateFieldName('Iva', TableMap::TYPE_PHPNAME, $indexType)];
            $this->iva = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : CompraTableMap::translateFieldName('PorcetajeRed', TableMap::TYPE_PHPNAME, $indexType)];
            $this->porcetaje_red = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = CompraTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating \Compra object", 0, $e);
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
        if ($this->aFactura !== null && $this->id_factura !== $this->aFactura->getIdFactura()) {
            $this->aFactura = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(CompraTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildCompraQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aFactura = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Compra::setDeleted()
     * @see Compra::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(CompraTableMap::DATABASE_NAME);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChildCompraQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(CompraTableMap::DATABASE_NAME);
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
                CompraTableMap::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aFactura !== null) {
                if ($this->aFactura->isModified() || $this->aFactura->isNew()) {
                    $affectedRows += $this->aFactura->save($con);
                }
                $this->setFactura($this->aFactura);
            }

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

        $this->modifiedColumns[] = CompraTableMap::ID_COMPRA;
        if (null !== $this->id_compra) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CompraTableMap::ID_COMPRA . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CompraTableMap::ID_PROD)) {
            $modifiedColumns[':p' . $index++]  = 'ID_PROD';
        }
        if ($this->isColumnModified(CompraTableMap::ID_COMPRA)) {
            $modifiedColumns[':p' . $index++]  = 'ID_COMPRA';
        }
        if ($this->isColumnModified(CompraTableMap::ID_FACTURA)) {
            $modifiedColumns[':p' . $index++]  = 'ID_FACTURA';
        }
        if ($this->isColumnModified(CompraTableMap::CANT_PROD)) {
            $modifiedColumns[':p' . $index++]  = 'CANT_PROD';
        }
        if ($this->isColumnModified(CompraTableMap::VALOR)) {
            $modifiedColumns[':p' . $index++]  = 'VALOR';
        }
        if ($this->isColumnModified(CompraTableMap::IVA)) {
            $modifiedColumns[':p' . $index++]  = 'IVA';
        }
        if ($this->isColumnModified(CompraTableMap::PORCETAJE_RED)) {
            $modifiedColumns[':p' . $index++]  = 'PORCETAJE_RED';
        }

        $sql = sprintf(
            'INSERT INTO compra (%s) VALUES (%s)',
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
                    case 'ID_COMPRA':
                        $stmt->bindValue($identifier, $this->id_compra, PDO::PARAM_INT);
                        break;
                    case 'ID_FACTURA':
                        $stmt->bindValue($identifier, $this->id_factura, PDO::PARAM_INT);
                        break;
                    case 'CANT_PROD':
                        $stmt->bindValue($identifier, $this->cant_prod, PDO::PARAM_INT);
                        break;
                    case 'VALOR':
                        $stmt->bindValue($identifier, $this->valor, PDO::PARAM_STR);
                        break;
                    case 'IVA':
                        $stmt->bindValue($identifier, $this->iva, PDO::PARAM_INT);
                        break;
                    case 'PORCETAJE_RED':
                        $stmt->bindValue($identifier, $this->porcetaje_red, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setIdCompra($pk);

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
        $pos = CompraTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdCompra();
                break;
            case 2:
                return $this->getIdFactura();
                break;
            case 3:
                return $this->getCantProd();
                break;
            case 4:
                return $this->getValor();
                break;
            case 5:
                return $this->getIva();
                break;
            case 6:
                return $this->getPorcetajeRed();
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
        if (isset($alreadyDumpedObjects['Compra'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Compra'][$this->getPrimaryKey()] = true;
        $keys = CompraTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getIdProd(),
            $keys[1] => $this->getIdCompra(),
            $keys[2] => $this->getIdFactura(),
            $keys[3] => $this->getCantProd(),
            $keys[4] => $this->getValor(),
            $keys[5] => $this->getIva(),
            $keys[6] => $this->getPorcetajeRed(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aFactura) {
                $result['Factura'] = $this->aFactura->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = CompraTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

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
                $this->setIdCompra($value);
                break;
            case 2:
                $this->setIdFactura($value);
                break;
            case 3:
                $this->setCantProd($value);
                break;
            case 4:
                $this->setValor($value);
                break;
            case 5:
                $this->setIva($value);
                break;
            case 6:
                $this->setPorcetajeRed($value);
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
        $keys = CompraTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setIdProd($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setIdCompra($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setIdFactura($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setCantProd($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setValor($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setIva($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setPorcetajeRed($arr[$keys[6]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CompraTableMap::DATABASE_NAME);

        if ($this->isColumnModified(CompraTableMap::ID_PROD)) $criteria->add(CompraTableMap::ID_PROD, $this->id_prod);
        if ($this->isColumnModified(CompraTableMap::ID_COMPRA)) $criteria->add(CompraTableMap::ID_COMPRA, $this->id_compra);
        if ($this->isColumnModified(CompraTableMap::ID_FACTURA)) $criteria->add(CompraTableMap::ID_FACTURA, $this->id_factura);
        if ($this->isColumnModified(CompraTableMap::CANT_PROD)) $criteria->add(CompraTableMap::CANT_PROD, $this->cant_prod);
        if ($this->isColumnModified(CompraTableMap::VALOR)) $criteria->add(CompraTableMap::VALOR, $this->valor);
        if ($this->isColumnModified(CompraTableMap::IVA)) $criteria->add(CompraTableMap::IVA, $this->iva);
        if ($this->isColumnModified(CompraTableMap::PORCETAJE_RED)) $criteria->add(CompraTableMap::PORCETAJE_RED, $this->porcetaje_red);

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
        $criteria = new Criteria(CompraTableMap::DATABASE_NAME);
        $criteria->add(CompraTableMap::ID_COMPRA, $this->id_compra);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return   int
     */
    public function getPrimaryKey()
    {
        return $this->getIdCompra();
    }

    /**
     * Generic method to set the primary key (id_compra column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setIdCompra($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getIdCompra();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Compra (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setIdProd($this->getIdProd());
        $copyObj->setIdFactura($this->getIdFactura());
        $copyObj->setCantProd($this->getCantProd());
        $copyObj->setValor($this->getValor());
        $copyObj->setIva($this->getIva());
        $copyObj->setPorcetajeRed($this->getPorcetajeRed());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setIdCompra(NULL); // this is a auto-increment column, so set to default value
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
     * @return                 \Compra Clone of current object.
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
     * Declares an association between this object and a ChildFactura object.
     *
     * @param                  ChildFactura $v
     * @return                 \Compra The current object (for fluent API support)
     * @throws PropelException
     */
    public function setFactura(ChildFactura $v = null)
    {
        if ($v === null) {
            $this->setIdFactura(NULL);
        } else {
            $this->setIdFactura($v->getIdFactura());
        }

        $this->aFactura = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildFactura object, it will not be re-added.
        if ($v !== null) {
            $v->addCompra($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildFactura object
     *
     * @param      ConnectionInterface $con Optional Connection object.
     * @return                 ChildFactura The associated ChildFactura object.
     * @throws PropelException
     */
    public function getFactura(ConnectionInterface $con = null)
    {
        if ($this->aFactura === null && ($this->id_factura !== null)) {
            $this->aFactura = ChildFacturaQuery::create()->findPk($this->id_factura, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aFactura->addCompras($this);
             */
        }

        return $this->aFactura;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id_prod = null;
        $this->id_compra = null;
        $this->id_factura = null;
        $this->cant_prod = null;
        $this->valor = null;
        $this->iva = null;
        $this->porcetaje_red = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
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
        } // if ($deep)

        $this->aFactura = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CompraTableMap::DEFAULT_STRING_FORMAT);
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
