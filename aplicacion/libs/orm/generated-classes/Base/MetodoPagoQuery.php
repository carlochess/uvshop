<?php

namespace Base;

use \MetodoPago as ChildMetodoPago;
use \MetodoPagoQuery as ChildMetodoPagoQuery;
use \Exception;
use \PDO;
use Map\MetodoPagoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'metodo_pago' table.
 *
 *
 *
 * @method     ChildMetodoPagoQuery orderByIdFactura($order = Criteria::ASC) Order by the id_factura column
 * @method     ChildMetodoPagoQuery orderByIdPago($order = Criteria::ASC) Order by the id_pago column
 * @method     ChildMetodoPagoQuery orderByTipo($order = Criteria::ASC) Order by the tipo column
 * @method     ChildMetodoPagoQuery orderByCuotas($order = Criteria::ASC) Order by the cuotas column
 * @method     ChildMetodoPagoQuery orderByMonto($order = Criteria::ASC) Order by the monto column
 *
 * @method     ChildMetodoPagoQuery groupByIdFactura() Group by the id_factura column
 * @method     ChildMetodoPagoQuery groupByIdPago() Group by the id_pago column
 * @method     ChildMetodoPagoQuery groupByTipo() Group by the tipo column
 * @method     ChildMetodoPagoQuery groupByCuotas() Group by the cuotas column
 * @method     ChildMetodoPagoQuery groupByMonto() Group by the monto column
 *
 * @method     ChildMetodoPagoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMetodoPagoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMetodoPagoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMetodoPagoQuery leftJoinFactura($relationAlias = null) Adds a LEFT JOIN clause to the query using the Factura relation
 * @method     ChildMetodoPagoQuery rightJoinFactura($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Factura relation
 * @method     ChildMetodoPagoQuery innerJoinFactura($relationAlias = null) Adds a INNER JOIN clause to the query using the Factura relation
 *
 * @method     ChildMetodoPago findOne(ConnectionInterface $con = null) Return the first ChildMetodoPago matching the query
 * @method     ChildMetodoPago findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMetodoPago matching the query, or a new ChildMetodoPago object populated from the query conditions when no match is found
 *
 * @method     ChildMetodoPago findOneByIdFactura(int $id_factura) Return the first ChildMetodoPago filtered by the id_factura column
 * @method     ChildMetodoPago findOneByIdPago(int $id_pago) Return the first ChildMetodoPago filtered by the id_pago column
 * @method     ChildMetodoPago findOneByTipo(string $tipo) Return the first ChildMetodoPago filtered by the tipo column
 * @method     ChildMetodoPago findOneByCuotas(int $cuotas) Return the first ChildMetodoPago filtered by the cuotas column
 * @method     ChildMetodoPago findOneByMonto(int $monto) Return the first ChildMetodoPago filtered by the monto column
 *
 * @method     array findByIdFactura(int $id_factura) Return ChildMetodoPago objects filtered by the id_factura column
 * @method     array findByIdPago(int $id_pago) Return ChildMetodoPago objects filtered by the id_pago column
 * @method     array findByTipo(string $tipo) Return ChildMetodoPago objects filtered by the tipo column
 * @method     array findByCuotas(int $cuotas) Return ChildMetodoPago objects filtered by the cuotas column
 * @method     array findByMonto(int $monto) Return ChildMetodoPago objects filtered by the monto column
 *
 */
abstract class MetodoPagoQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\MetodoPagoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'uvshop', $modelName = '\\MetodoPago', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMetodoPagoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMetodoPagoQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \MetodoPagoQuery) {
            return $criteria;
        }
        $query = new \MetodoPagoQuery();
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
     * @return ChildMetodoPago|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MetodoPagoTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MetodoPagoTableMap::DATABASE_NAME);
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
     * @return   ChildMetodoPago A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID_FACTURA, ID_PAGO, TIPO, CUOTAS, MONTO FROM metodo_pago WHERE ID_PAGO = :p0';
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
            $obj = new ChildMetodoPago();
            $obj->hydrate($row);
            MetodoPagoTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildMetodoPago|array|mixed the result, formatted by the current formatter
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
     * @return ChildMetodoPagoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MetodoPagoTableMap::ID_PAGO, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildMetodoPagoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MetodoPagoTableMap::ID_PAGO, $keys, Criteria::IN);
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
     * @see       filterByFactura()
     *
     * @param     mixed $idFactura The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMetodoPagoQuery The current query, for fluid interface
     */
    public function filterByIdFactura($idFactura = null, $comparison = null)
    {
        if (is_array($idFactura)) {
            $useMinMax = false;
            if (isset($idFactura['min'])) {
                $this->addUsingAlias(MetodoPagoTableMap::ID_FACTURA, $idFactura['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idFactura['max'])) {
                $this->addUsingAlias(MetodoPagoTableMap::ID_FACTURA, $idFactura['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MetodoPagoTableMap::ID_FACTURA, $idFactura, $comparison);
    }

    /**
     * Filter the query on the id_pago column
     *
     * Example usage:
     * <code>
     * $query->filterByIdPago(1234); // WHERE id_pago = 1234
     * $query->filterByIdPago(array(12, 34)); // WHERE id_pago IN (12, 34)
     * $query->filterByIdPago(array('min' => 12)); // WHERE id_pago > 12
     * </code>
     *
     * @param     mixed $idPago The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMetodoPagoQuery The current query, for fluid interface
     */
    public function filterByIdPago($idPago = null, $comparison = null)
    {
        if (is_array($idPago)) {
            $useMinMax = false;
            if (isset($idPago['min'])) {
                $this->addUsingAlias(MetodoPagoTableMap::ID_PAGO, $idPago['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idPago['max'])) {
                $this->addUsingAlias(MetodoPagoTableMap::ID_PAGO, $idPago['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MetodoPagoTableMap::ID_PAGO, $idPago, $comparison);
    }

    /**
     * Filter the query on the tipo column
     *
     * Example usage:
     * <code>
     * $query->filterByTipo('fooValue');   // WHERE tipo = 'fooValue'
     * $query->filterByTipo('%fooValue%'); // WHERE tipo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tipo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMetodoPagoQuery The current query, for fluid interface
     */
    public function filterByTipo($tipo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tipo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tipo)) {
                $tipo = str_replace('*', '%', $tipo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MetodoPagoTableMap::TIPO, $tipo, $comparison);
    }

    /**
     * Filter the query on the cuotas column
     *
     * Example usage:
     * <code>
     * $query->filterByCuotas(1234); // WHERE cuotas = 1234
     * $query->filterByCuotas(array(12, 34)); // WHERE cuotas IN (12, 34)
     * $query->filterByCuotas(array('min' => 12)); // WHERE cuotas > 12
     * </code>
     *
     * @param     mixed $cuotas The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMetodoPagoQuery The current query, for fluid interface
     */
    public function filterByCuotas($cuotas = null, $comparison = null)
    {
        if (is_array($cuotas)) {
            $useMinMax = false;
            if (isset($cuotas['min'])) {
                $this->addUsingAlias(MetodoPagoTableMap::CUOTAS, $cuotas['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cuotas['max'])) {
                $this->addUsingAlias(MetodoPagoTableMap::CUOTAS, $cuotas['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MetodoPagoTableMap::CUOTAS, $cuotas, $comparison);
    }

    /**
     * Filter the query on the monto column
     *
     * Example usage:
     * <code>
     * $query->filterByMonto(1234); // WHERE monto = 1234
     * $query->filterByMonto(array(12, 34)); // WHERE monto IN (12, 34)
     * $query->filterByMonto(array('min' => 12)); // WHERE monto > 12
     * </code>
     *
     * @param     mixed $monto The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMetodoPagoQuery The current query, for fluid interface
     */
    public function filterByMonto($monto = null, $comparison = null)
    {
        if (is_array($monto)) {
            $useMinMax = false;
            if (isset($monto['min'])) {
                $this->addUsingAlias(MetodoPagoTableMap::MONTO, $monto['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($monto['max'])) {
                $this->addUsingAlias(MetodoPagoTableMap::MONTO, $monto['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MetodoPagoTableMap::MONTO, $monto, $comparison);
    }

    /**
     * Filter the query by a related \Factura object
     *
     * @param \Factura|ObjectCollection $factura The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMetodoPagoQuery The current query, for fluid interface
     */
    public function filterByFactura($factura, $comparison = null)
    {
        if ($factura instanceof \Factura) {
            return $this
                ->addUsingAlias(MetodoPagoTableMap::ID_FACTURA, $factura->getIdFactura(), $comparison);
        } elseif ($factura instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MetodoPagoTableMap::ID_FACTURA, $factura->toKeyValue('PrimaryKey', 'IdFactura'), $comparison);
        } else {
            throw new PropelException('filterByFactura() only accepts arguments of type \Factura or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Factura relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildMetodoPagoQuery The current query, for fluid interface
     */
    public function joinFactura($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Factura');

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
            $this->addJoinObject($join, 'Factura');
        }

        return $this;
    }

    /**
     * Use the Factura relation Factura object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \FacturaQuery A secondary query class using the current class as primary query
     */
    public function useFacturaQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFactura($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Factura', '\FacturaQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMetodoPago $metodoPago Object to remove from the list of results
     *
     * @return ChildMetodoPagoQuery The current query, for fluid interface
     */
    public function prune($metodoPago = null)
    {
        if ($metodoPago) {
            $this->addUsingAlias(MetodoPagoTableMap::ID_PAGO, $metodoPago->getIdPago(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the metodo_pago table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MetodoPagoTableMap::DATABASE_NAME);
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
            MetodoPagoTableMap::clearInstancePool();
            MetodoPagoTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildMetodoPago or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildMetodoPago object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MetodoPagoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MetodoPagoTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        MetodoPagoTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MetodoPagoTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // MetodoPagoQuery
