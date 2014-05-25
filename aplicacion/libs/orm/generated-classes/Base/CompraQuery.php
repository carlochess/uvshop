<?php

namespace Base;

use \Compra as ChildCompra;
use \CompraQuery as ChildCompraQuery;
use \Exception;
use \PDO;
use Map\CompraTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'compra' table.
 *
 *
 *
 * @method     ChildCompraQuery orderByIdProd($order = Criteria::ASC) Order by the id_prod column
 * @method     ChildCompraQuery orderByIdCompra($order = Criteria::ASC) Order by the id_compra column
 * @method     ChildCompraQuery orderByIdFactura($order = Criteria::ASC) Order by the id_factura column
 * @method     ChildCompraQuery orderByCantProd($order = Criteria::ASC) Order by the cant_prod column
 * @method     ChildCompraQuery orderByValor($order = Criteria::ASC) Order by the valor column
 * @method     ChildCompraQuery orderByIva($order = Criteria::ASC) Order by the iva column
 * @method     ChildCompraQuery orderByPorcetajeRed($order = Criteria::ASC) Order by the porcetaje_red column
 *
 * @method     ChildCompraQuery groupByIdProd() Group by the id_prod column
 * @method     ChildCompraQuery groupByIdCompra() Group by the id_compra column
 * @method     ChildCompraQuery groupByIdFactura() Group by the id_factura column
 * @method     ChildCompraQuery groupByCantProd() Group by the cant_prod column
 * @method     ChildCompraQuery groupByValor() Group by the valor column
 * @method     ChildCompraQuery groupByIva() Group by the iva column
 * @method     ChildCompraQuery groupByPorcetajeRed() Group by the porcetaje_red column
 *
 * @method     ChildCompraQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCompraQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCompraQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCompraQuery leftJoinFactura($relationAlias = null) Adds a LEFT JOIN clause to the query using the Factura relation
 * @method     ChildCompraQuery rightJoinFactura($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Factura relation
 * @method     ChildCompraQuery innerJoinFactura($relationAlias = null) Adds a INNER JOIN clause to the query using the Factura relation
 *
 * @method     ChildCompra findOne(ConnectionInterface $con = null) Return the first ChildCompra matching the query
 * @method     ChildCompra findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCompra matching the query, or a new ChildCompra object populated from the query conditions when no match is found
 *
 * @method     ChildCompra findOneByIdProd(string $id_prod) Return the first ChildCompra filtered by the id_prod column
 * @method     ChildCompra findOneByIdCompra(int $id_compra) Return the first ChildCompra filtered by the id_compra column
 * @method     ChildCompra findOneByIdFactura(int $id_factura) Return the first ChildCompra filtered by the id_factura column
 * @method     ChildCompra findOneByCantProd(int $cant_prod) Return the first ChildCompra filtered by the cant_prod column
 * @method     ChildCompra findOneByValor(string $valor) Return the first ChildCompra filtered by the valor column
 * @method     ChildCompra findOneByIva(int $iva) Return the first ChildCompra filtered by the iva column
 * @method     ChildCompra findOneByPorcetajeRed(int $porcetaje_red) Return the first ChildCompra filtered by the porcetaje_red column
 *
 * @method     array findByIdProd(string $id_prod) Return ChildCompra objects filtered by the id_prod column
 * @method     array findByIdCompra(int $id_compra) Return ChildCompra objects filtered by the id_compra column
 * @method     array findByIdFactura(int $id_factura) Return ChildCompra objects filtered by the id_factura column
 * @method     array findByCantProd(int $cant_prod) Return ChildCompra objects filtered by the cant_prod column
 * @method     array findByValor(string $valor) Return ChildCompra objects filtered by the valor column
 * @method     array findByIva(int $iva) Return ChildCompra objects filtered by the iva column
 * @method     array findByPorcetajeRed(int $porcetaje_red) Return ChildCompra objects filtered by the porcetaje_red column
 *
 */
abstract class CompraQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\CompraQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'uvshop', $modelName = '\\Compra', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCompraQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCompraQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \CompraQuery) {
            return $criteria;
        }
        $query = new \CompraQuery();
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
     * @return ChildCompra|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CompraTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CompraTableMap::DATABASE_NAME);
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
     * @return   ChildCompra A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID_PROD, ID_COMPRA, ID_FACTURA, CANT_PROD, VALOR, IVA, PORCETAJE_RED FROM compra WHERE ID_COMPRA = :p0';
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
            $obj = new ChildCompra();
            $obj->hydrate($row);
            CompraTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCompra|array|mixed the result, formatted by the current formatter
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
     * @return ChildCompraQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CompraTableMap::ID_COMPRA, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildCompraQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CompraTableMap::ID_COMPRA, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_prod column
     *
     * Example usage:
     * <code>
     * $query->filterByIdProd('fooValue');   // WHERE id_prod = 'fooValue'
     * $query->filterByIdProd('%fooValue%'); // WHERE id_prod LIKE '%fooValue%'
     * </code>
     *
     * @param     string $idProd The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCompraQuery The current query, for fluid interface
     */
    public function filterByIdProd($idProd = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($idProd)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $idProd)) {
                $idProd = str_replace('*', '%', $idProd);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CompraTableMap::ID_PROD, $idProd, $comparison);
    }

    /**
     * Filter the query on the id_compra column
     *
     * Example usage:
     * <code>
     * $query->filterByIdCompra(1234); // WHERE id_compra = 1234
     * $query->filterByIdCompra(array(12, 34)); // WHERE id_compra IN (12, 34)
     * $query->filterByIdCompra(array('min' => 12)); // WHERE id_compra > 12
     * </code>
     *
     * @param     mixed $idCompra The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCompraQuery The current query, for fluid interface
     */
    public function filterByIdCompra($idCompra = null, $comparison = null)
    {
        if (is_array($idCompra)) {
            $useMinMax = false;
            if (isset($idCompra['min'])) {
                $this->addUsingAlias(CompraTableMap::ID_COMPRA, $idCompra['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idCompra['max'])) {
                $this->addUsingAlias(CompraTableMap::ID_COMPRA, $idCompra['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompraTableMap::ID_COMPRA, $idCompra, $comparison);
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
     * @return ChildCompraQuery The current query, for fluid interface
     */
    public function filterByIdFactura($idFactura = null, $comparison = null)
    {
        if (is_array($idFactura)) {
            $useMinMax = false;
            if (isset($idFactura['min'])) {
                $this->addUsingAlias(CompraTableMap::ID_FACTURA, $idFactura['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idFactura['max'])) {
                $this->addUsingAlias(CompraTableMap::ID_FACTURA, $idFactura['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompraTableMap::ID_FACTURA, $idFactura, $comparison);
    }

    /**
     * Filter the query on the cant_prod column
     *
     * Example usage:
     * <code>
     * $query->filterByCantProd(1234); // WHERE cant_prod = 1234
     * $query->filterByCantProd(array(12, 34)); // WHERE cant_prod IN (12, 34)
     * $query->filterByCantProd(array('min' => 12)); // WHERE cant_prod > 12
     * </code>
     *
     * @param     mixed $cantProd The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCompraQuery The current query, for fluid interface
     */
    public function filterByCantProd($cantProd = null, $comparison = null)
    {
        if (is_array($cantProd)) {
            $useMinMax = false;
            if (isset($cantProd['min'])) {
                $this->addUsingAlias(CompraTableMap::CANT_PROD, $cantProd['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cantProd['max'])) {
                $this->addUsingAlias(CompraTableMap::CANT_PROD, $cantProd['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompraTableMap::CANT_PROD, $cantProd, $comparison);
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
     * @return ChildCompraQuery The current query, for fluid interface
     */
    public function filterByValor($valor = null, $comparison = null)
    {
        if (is_array($valor)) {
            $useMinMax = false;
            if (isset($valor['min'])) {
                $this->addUsingAlias(CompraTableMap::VALOR, $valor['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($valor['max'])) {
                $this->addUsingAlias(CompraTableMap::VALOR, $valor['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompraTableMap::VALOR, $valor, $comparison);
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
     * @return ChildCompraQuery The current query, for fluid interface
     */
    public function filterByIva($iva = null, $comparison = null)
    {
        if (is_array($iva)) {
            $useMinMax = false;
            if (isset($iva['min'])) {
                $this->addUsingAlias(CompraTableMap::IVA, $iva['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iva['max'])) {
                $this->addUsingAlias(CompraTableMap::IVA, $iva['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompraTableMap::IVA, $iva, $comparison);
    }

    /**
     * Filter the query on the porcetaje_red column
     *
     * Example usage:
     * <code>
     * $query->filterByPorcetajeRed(1234); // WHERE porcetaje_red = 1234
     * $query->filterByPorcetajeRed(array(12, 34)); // WHERE porcetaje_red IN (12, 34)
     * $query->filterByPorcetajeRed(array('min' => 12)); // WHERE porcetaje_red > 12
     * </code>
     *
     * @param     mixed $porcetajeRed The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCompraQuery The current query, for fluid interface
     */
    public function filterByPorcetajeRed($porcetajeRed = null, $comparison = null)
    {
        if (is_array($porcetajeRed)) {
            $useMinMax = false;
            if (isset($porcetajeRed['min'])) {
                $this->addUsingAlias(CompraTableMap::PORCETAJE_RED, $porcetajeRed['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($porcetajeRed['max'])) {
                $this->addUsingAlias(CompraTableMap::PORCETAJE_RED, $porcetajeRed['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CompraTableMap::PORCETAJE_RED, $porcetajeRed, $comparison);
    }

    /**
     * Filter the query by a related \Factura object
     *
     * @param \Factura|ObjectCollection $factura The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCompraQuery The current query, for fluid interface
     */
    public function filterByFactura($factura, $comparison = null)
    {
        if ($factura instanceof \Factura) {
            return $this
                ->addUsingAlias(CompraTableMap::ID_FACTURA, $factura->getIdFactura(), $comparison);
        } elseif ($factura instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CompraTableMap::ID_FACTURA, $factura->toKeyValue('PrimaryKey', 'IdFactura'), $comparison);
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
     * @return ChildCompraQuery The current query, for fluid interface
     */
    public function joinFactura($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useFacturaQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFactura($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Factura', '\FacturaQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCompra $compra Object to remove from the list of results
     *
     * @return ChildCompraQuery The current query, for fluid interface
     */
    public function prune($compra = null)
    {
        if ($compra) {
            $this->addUsingAlias(CompraTableMap::ID_COMPRA, $compra->getIdCompra(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the compra table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CompraTableMap::DATABASE_NAME);
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
            CompraTableMap::clearInstancePool();
            CompraTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildCompra or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildCompra object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(CompraTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CompraTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        CompraTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CompraTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // CompraQuery
