<?php

namespace Base;

use \Factura as ChildFactura;
use \FacturaQuery as ChildFacturaQuery;
use \Exception;
use \PDO;
use Map\FacturaTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'factura' table.
 *
 *
 *
 * @method     ChildFacturaQuery orderByIdFactura($order = Criteria::ASC) Order by the id_factura column
 * @method     ChildFacturaQuery orderByIdCliente($order = Criteria::ASC) Order by the id_cliente column
 * @method     ChildFacturaQuery orderByFecha($order = Criteria::ASC) Order by the fecha column
 * @method     ChildFacturaQuery orderByCantidadProductos($order = Criteria::ASC) Order by the cantidad_productos column
 * @method     ChildFacturaQuery orderByValor($order = Criteria::ASC) Order by the valor column
 * @method     ChildFacturaQuery orderByIva($order = Criteria::ASC) Order by the iva column
 *
 * @method     ChildFacturaQuery groupByIdFactura() Group by the id_factura column
 * @method     ChildFacturaQuery groupByIdCliente() Group by the id_cliente column
 * @method     ChildFacturaQuery groupByFecha() Group by the fecha column
 * @method     ChildFacturaQuery groupByCantidadProductos() Group by the cantidad_productos column
 * @method     ChildFacturaQuery groupByValor() Group by the valor column
 * @method     ChildFacturaQuery groupByIva() Group by the iva column
 *
 * @method     ChildFacturaQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildFacturaQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildFacturaQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildFacturaQuery leftJoinProducto($relationAlias = null) Adds a LEFT JOIN clause to the query using the Producto relation
 * @method     ChildFacturaQuery rightJoinProducto($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Producto relation
 * @method     ChildFacturaQuery innerJoinProducto($relationAlias = null) Adds a INNER JOIN clause to the query using the Producto relation
 *
 * @method     ChildFactura findOne(ConnectionInterface $con = null) Return the first ChildFactura matching the query
 * @method     ChildFactura findOneOrCreate(ConnectionInterface $con = null) Return the first ChildFactura matching the query, or a new ChildFactura object populated from the query conditions when no match is found
 *
 * @method     ChildFactura findOneByIdFactura(int $id_factura) Return the first ChildFactura filtered by the id_factura column
 * @method     ChildFactura findOneByIdCliente(string $id_cliente) Return the first ChildFactura filtered by the id_cliente column
 * @method     ChildFactura findOneByFecha(string $fecha) Return the first ChildFactura filtered by the fecha column
 * @method     ChildFactura findOneByCantidadProductos(int $cantidad_productos) Return the first ChildFactura filtered by the cantidad_productos column
 * @method     ChildFactura findOneByValor(string $valor) Return the first ChildFactura filtered by the valor column
 * @method     ChildFactura findOneByIva(int $iva) Return the first ChildFactura filtered by the iva column
 *
 * @method     array findByIdFactura(int $id_factura) Return ChildFactura objects filtered by the id_factura column
 * @method     array findByIdCliente(string $id_cliente) Return ChildFactura objects filtered by the id_cliente column
 * @method     array findByFecha(string $fecha) Return ChildFactura objects filtered by the fecha column
 * @method     array findByCantidadProductos(int $cantidad_productos) Return ChildFactura objects filtered by the cantidad_productos column
 * @method     array findByValor(string $valor) Return ChildFactura objects filtered by the valor column
 * @method     array findByIva(int $iva) Return ChildFactura objects filtered by the iva column
 *
 */
abstract class FacturaQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\FacturaQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'uvshop', $modelName = '\\Factura', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildFacturaQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildFacturaQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \FacturaQuery) {
            return $criteria;
        }
        $query = new \FacturaQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildFactura|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FacturaTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(FacturaTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildFactura A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID_FACTURA, ID_CLIENTE, FECHA, CANTIDAD_PRODUCTOS, VALOR, IVA FROM factura WHERE ID_FACTURA = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildFactura();
            $obj->hydrate($row);
            FacturaTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildFactura|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildFacturaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FacturaTableMap::ID_FACTURA, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildFacturaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FacturaTableMap::ID_FACTURA, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_factura column
     *
     * Example usage:
     * <code>
     * $query->filterByIdFactura(1234); // WHERE id_factura = 1234
     * $query->filterByIdFactura(array(12, 34)); // WHERE id_factura IN (12, 34)
     * $query->filterByIdFactura(array('min' => 12)); // WHERE id_factura > 12
     * </code>
     *
     * @param     mixed $idFactura The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFacturaQuery The current query, for fluid interface
     */
    public function filterByIdFactura($idFactura = null, $comparison = null)
    {
        if (is_array($idFactura)) {
            $useMinMax = false;
            if (isset($idFactura['min'])) {
                $this->addUsingAlias(FacturaTableMap::ID_FACTURA, $idFactura['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idFactura['max'])) {
                $this->addUsingAlias(FacturaTableMap::ID_FACTURA, $idFactura['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FacturaTableMap::ID_FACTURA, $idFactura, $comparison);
    }

    /**
     * Filter the query on the id_cliente column
     *
     * Example usage:
     * <code>
     * $query->filterByIdCliente('fooValue');   // WHERE id_cliente = 'fooValue'
     * $query->filterByIdCliente('%fooValue%'); // WHERE id_cliente LIKE '%fooValue%'
     * </code>
     *
     * @param     string $idCliente The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFacturaQuery The current query, for fluid interface
     */
    public function filterByIdCliente($idCliente = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($idCliente)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $idCliente)) {
                $idCliente = str_replace('*', '%', $idCliente);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FacturaTableMap::ID_CLIENTE, $idCliente, $comparison);
    }

    /**
     * Filter the query on the fecha column
     *
     * Example usage:
     * <code>
     * $query->filterByFecha('2011-03-14'); // WHERE fecha = '2011-03-14'
     * $query->filterByFecha('now'); // WHERE fecha = '2011-03-14'
     * $query->filterByFecha(array('max' => 'yesterday')); // WHERE fecha > '2011-03-13'
     * </code>
     *
     * @param     mixed $fecha The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFacturaQuery The current query, for fluid interface
     */
    public function filterByFecha($fecha = null, $comparison = null)
    {
        if (is_array($fecha)) {
            $useMinMax = false;
            if (isset($fecha['min'])) {
                $this->addUsingAlias(FacturaTableMap::FECHA, $fecha['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fecha['max'])) {
                $this->addUsingAlias(FacturaTableMap::FECHA, $fecha['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FacturaTableMap::FECHA, $fecha, $comparison);
    }

    /**
     * Filter the query on the cantidad_productos column
     *
     * Example usage:
     * <code>
     * $query->filterByCantidadProductos(1234); // WHERE cantidad_productos = 1234
     * $query->filterByCantidadProductos(array(12, 34)); // WHERE cantidad_productos IN (12, 34)
     * $query->filterByCantidadProductos(array('min' => 12)); // WHERE cantidad_productos > 12
     * </code>
     *
     * @param     mixed $cantidadProductos The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFacturaQuery The current query, for fluid interface
     */
    public function filterByCantidadProductos($cantidadProductos = null, $comparison = null)
    {
        if (is_array($cantidadProductos)) {
            $useMinMax = false;
            if (isset($cantidadProductos['min'])) {
                $this->addUsingAlias(FacturaTableMap::CANTIDAD_PRODUCTOS, $cantidadProductos['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cantidadProductos['max'])) {
                $this->addUsingAlias(FacturaTableMap::CANTIDAD_PRODUCTOS, $cantidadProductos['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FacturaTableMap::CANTIDAD_PRODUCTOS, $cantidadProductos, $comparison);
    }

    /**
     * Filter the query on the valor column
     *
     * Example usage:
     * <code>
     * $query->filterByValor(1234); // WHERE valor = 1234
     * $query->filterByValor(array(12, 34)); // WHERE valor IN (12, 34)
     * $query->filterByValor(array('min' => 12)); // WHERE valor > 12
     * </code>
     *
     * @param     mixed $valor The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFacturaQuery The current query, for fluid interface
     */
    public function filterByValor($valor = null, $comparison = null)
    {
        if (is_array($valor)) {
            $useMinMax = false;
            if (isset($valor['min'])) {
                $this->addUsingAlias(FacturaTableMap::VALOR, $valor['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($valor['max'])) {
                $this->addUsingAlias(FacturaTableMap::VALOR, $valor['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FacturaTableMap::VALOR, $valor, $comparison);
    }

    /**
     * Filter the query on the iva column
     *
     * Example usage:
     * <code>
     * $query->filterByIva(1234); // WHERE iva = 1234
     * $query->filterByIva(array(12, 34)); // WHERE iva IN (12, 34)
     * $query->filterByIva(array('min' => 12)); // WHERE iva > 12
     * </code>
     *
     * @param     mixed $iva The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFacturaQuery The current query, for fluid interface
     */
    public function filterByIva($iva = null, $comparison = null)
    {
        if (is_array($iva)) {
            $useMinMax = false;
            if (isset($iva['min'])) {
                $this->addUsingAlias(FacturaTableMap::IVA, $iva['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iva['max'])) {
                $this->addUsingAlias(FacturaTableMap::IVA, $iva['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FacturaTableMap::IVA, $iva, $comparison);
    }

    /**
     * Filter the query by a related \Producto object
     *
     * @param \Producto|ObjectCollection $producto The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildFacturaQuery The current query, for fluid interface
     */
    public function filterByProducto($producto, $comparison = null)
    {
        if ($producto instanceof \Producto) {
            return $this
                ->addUsingAlias(FacturaTableMap::ID_CLIENTE, $producto->getIdProd(), $comparison);
        } elseif ($producto instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FacturaTableMap::ID_CLIENTE, $producto->toKeyValue('PrimaryKey', 'IdProd'), $comparison);
        } else {
            throw new PropelException('filterByProducto() only accepts arguments of type \Producto or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Producto relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildFacturaQuery The current query, for fluid interface
     */
    public function joinProducto($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Producto');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Producto');
        }

        return $this;
    }

    /**
     * Use the Producto relation Producto object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \ProductoQuery A secondary query class using the current class as primary query
     */
    public function useProductoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProducto($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Producto', '\ProductoQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildFactura $factura Object to remove from the list of results
     *
     * @return ChildFacturaQuery The current query, for fluid interface
     */
    public function prune($factura = null)
    {
        if ($factura) {
            $this->addUsingAlias(FacturaTableMap::ID_FACTURA, $factura->getIdFactura(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the factura table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FacturaTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FacturaTableMap::clearInstancePool();
            FacturaTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildFactura or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildFactura object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(FacturaTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(FacturaTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        FacturaTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            FacturaTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // FacturaQuery
