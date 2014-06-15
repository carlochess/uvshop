<?php

namespace Base;

use \Promocion as ChildPromocion;
use \PromocionQuery as ChildPromocionQuery;
use \Exception;
use \PDO;
use Map\PromocionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'promocion' table.
 *
 *
 *
 * @method     ChildPromocionQuery orderByIdPromocion($order = Criteria::ASC) Order by the id_promocion column
 * @method     ChildPromocionQuery orderByCodProducto($order = Criteria::ASC) Order by the cod_producto column
 * @method     ChildPromocionQuery orderByFechaIni($order = Criteria::ASC) Order by the fecha_ini column
 * @method     ChildPromocionQuery orderByFechaFin($order = Criteria::ASC) Order by the fecha_fin column
 * @method     ChildPromocionQuery orderByValor($order = Criteria::ASC) Order by the valor column
 * @method     ChildPromocionQuery orderByPorcetajeRed($order = Criteria::ASC) Order by the porcetaje_red column
 *
 * @method     ChildPromocionQuery groupByIdPromocion() Group by the id_promocion column
 * @method     ChildPromocionQuery groupByCodProducto() Group by the cod_producto column
 * @method     ChildPromocionQuery groupByFechaIni() Group by the fecha_ini column
 * @method     ChildPromocionQuery groupByFechaFin() Group by the fecha_fin column
 * @method     ChildPromocionQuery groupByValor() Group by the valor column
 * @method     ChildPromocionQuery groupByPorcetajeRed() Group by the porcetaje_red column
 *
 * @method     ChildPromocionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPromocionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPromocionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPromocionQuery leftJoinProducto($relationAlias = null) Adds a LEFT JOIN clause to the query using the Producto relation
 * @method     ChildPromocionQuery rightJoinProducto($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Producto relation
 * @method     ChildPromocionQuery innerJoinProducto($relationAlias = null) Adds a INNER JOIN clause to the query using the Producto relation
 *
 * @method     ChildPromocion findOne(ConnectionInterface $con = null) Return the first ChildPromocion matching the query
 * @method     ChildPromocion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPromocion matching the query, or a new ChildPromocion object populated from the query conditions when no match is found
 *
 * @method     ChildPromocion findOneByIdPromocion(int $id_promocion) Return the first ChildPromocion filtered by the id_promocion column
 * @method     ChildPromocion findOneByCodProducto(string $cod_producto) Return the first ChildPromocion filtered by the cod_producto column
 * @method     ChildPromocion findOneByFechaIni(string $fecha_ini) Return the first ChildPromocion filtered by the fecha_ini column
 * @method     ChildPromocion findOneByFechaFin(string $fecha_fin) Return the first ChildPromocion filtered by the fecha_fin column
 * @method     ChildPromocion findOneByValor(string $valor) Return the first ChildPromocion filtered by the valor column
 * @method     ChildPromocion findOneByPorcetajeRed(int $porcetaje_red) Return the first ChildPromocion filtered by the porcetaje_red column
 *
 * @method     array findByIdPromocion(int $id_promocion) Return ChildPromocion objects filtered by the id_promocion column
 * @method     array findByCodProducto(string $cod_producto) Return ChildPromocion objects filtered by the cod_producto column
 * @method     array findByFechaIni(string $fecha_ini) Return ChildPromocion objects filtered by the fecha_ini column
 * @method     array findByFechaFin(string $fecha_fin) Return ChildPromocion objects filtered by the fecha_fin column
 * @method     array findByValor(string $valor) Return ChildPromocion objects filtered by the valor column
 * @method     array findByPorcetajeRed(int $porcetaje_red) Return ChildPromocion objects filtered by the porcetaje_red column
 *
 */
abstract class PromocionQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\PromocionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'uvshop', $modelName = '\\Promocion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPromocionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPromocionQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \PromocionQuery) {
            return $criteria;
        }
        $query = new \PromocionQuery();
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
     * @return ChildPromocion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PromocionTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PromocionTableMap::DATABASE_NAME);
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
     * @return   ChildPromocion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID_PROMOCION, COD_PRODUCTO, FECHA_INI, FECHA_FIN, VALOR, PORCETAJE_RED FROM promocion WHERE ID_PROMOCION = :p0';
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
            $obj = new ChildPromocion();
            $obj->hydrate($row);
            PromocionTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPromocion|array|mixed the result, formatted by the current formatter
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
     * @return ChildPromocionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PromocionTableMap::ID_PROMOCION, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildPromocionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PromocionTableMap::ID_PROMOCION, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_promocion column
     *
     * Example usage:
     * <code>
     * $query->filterByIdPromocion(1234); // WHERE id_promocion = 1234
     * $query->filterByIdPromocion(array(12, 34)); // WHERE id_promocion IN (12, 34)
     * $query->filterByIdPromocion(array('min' => 12)); // WHERE id_promocion > 12
     * </code>
     *
     * @param     mixed $idPromocion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPromocionQuery The current query, for fluid interface
     */
    public function filterByIdPromocion($idPromocion = null, $comparison = null)
    {
        if (is_array($idPromocion)) {
            $useMinMax = false;
            if (isset($idPromocion['min'])) {
                $this->addUsingAlias(PromocionTableMap::ID_PROMOCION, $idPromocion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idPromocion['max'])) {
                $this->addUsingAlias(PromocionTableMap::ID_PROMOCION, $idPromocion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PromocionTableMap::ID_PROMOCION, $idPromocion, $comparison);
    }

    /**
     * Filter the query on the cod_producto column
     *
     * Example usage:
     * <code>
     * $query->filterByCodProducto('fooValue');   // WHERE cod_producto = 'fooValue'
     * $query->filterByCodProducto('%fooValue%'); // WHERE cod_producto LIKE '%fooValue%'
     * </code>
     *
     * @param     string $codProducto The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPromocionQuery The current query, for fluid interface
     */
    public function filterByCodProducto($codProducto = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($codProducto)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $codProducto)) {
                $codProducto = str_replace('*', '%', $codProducto);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PromocionTableMap::COD_PRODUCTO, $codProducto, $comparison);
    }

    /**
     * Filter the query on the fecha_ini column
     *
     * Example usage:
     * <code>
     * $query->filterByFechaIni('2011-03-14'); // WHERE fecha_ini = '2011-03-14'
     * $query->filterByFechaIni('now'); // WHERE fecha_ini = '2011-03-14'
     * $query->filterByFechaIni(array('max' => 'yesterday')); // WHERE fecha_ini > '2011-03-13'
     * </code>
     *
     * @param     mixed $fechaIni The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPromocionQuery The current query, for fluid interface
     */
    public function filterByFechaIni($fechaIni = null, $comparison = null)
    {
        if (is_array($fechaIni)) {
            $useMinMax = false;
            if (isset($fechaIni['min'])) {
                $this->addUsingAlias(PromocionTableMap::FECHA_INI, $fechaIni['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fechaIni['max'])) {
                $this->addUsingAlias(PromocionTableMap::FECHA_INI, $fechaIni['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PromocionTableMap::FECHA_INI, $fechaIni, $comparison);
    }

    /**
     * Filter the query on the fecha_fin column
     *
     * Example usage:
     * <code>
     * $query->filterByFechaFin('2011-03-14'); // WHERE fecha_fin = '2011-03-14'
     * $query->filterByFechaFin('now'); // WHERE fecha_fin = '2011-03-14'
     * $query->filterByFechaFin(array('max' => 'yesterday')); // WHERE fecha_fin > '2011-03-13'
     * </code>
     *
     * @param     mixed $fechaFin The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPromocionQuery The current query, for fluid interface
     */
    public function filterByFechaFin($fechaFin = null, $comparison = null)
    {
        if (is_array($fechaFin)) {
            $useMinMax = false;
            if (isset($fechaFin['min'])) {
                $this->addUsingAlias(PromocionTableMap::FECHA_FIN, $fechaFin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fechaFin['max'])) {
                $this->addUsingAlias(PromocionTableMap::FECHA_FIN, $fechaFin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PromocionTableMap::FECHA_FIN, $fechaFin, $comparison);
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
     * @return ChildPromocionQuery The current query, for fluid interface
     */
    public function filterByValor($valor = null, $comparison = null)
    {
        if (is_array($valor)) {
            $useMinMax = false;
            if (isset($valor['min'])) {
                $this->addUsingAlias(PromocionTableMap::VALOR, $valor['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($valor['max'])) {
                $this->addUsingAlias(PromocionTableMap::VALOR, $valor['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PromocionTableMap::VALOR, $valor, $comparison);
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
     * @return ChildPromocionQuery The current query, for fluid interface
     */
    public function filterByPorcetajeRed($porcetajeRed = null, $comparison = null)
    {
        if (is_array($porcetajeRed)) {
            $useMinMax = false;
            if (isset($porcetajeRed['min'])) {
                $this->addUsingAlias(PromocionTableMap::PORCETAJE_RED, $porcetajeRed['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($porcetajeRed['max'])) {
                $this->addUsingAlias(PromocionTableMap::PORCETAJE_RED, $porcetajeRed['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PromocionTableMap::PORCETAJE_RED, $porcetajeRed, $comparison);
    }

    /**
     * Filter the query by a related \Producto object
     *
     * @param \Producto|ObjectCollection $producto The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPromocionQuery The current query, for fluid interface
     */
    public function filterByProducto($producto, $comparison = null)
    {
        if ($producto instanceof \Producto) {
            return $this
                ->addUsingAlias(PromocionTableMap::COD_PRODUCTO, $producto->getIdProd(), $comparison);
        } elseif ($producto instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PromocionTableMap::COD_PRODUCTO, $producto->toKeyValue('PrimaryKey', 'IdProd'), $comparison);
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
     * @return ChildPromocionQuery The current query, for fluid interface
     */
    public function joinProducto($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useProductoQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProducto($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Producto', '\ProductoQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPromocion $promocion Object to remove from the list of results
     *
     * @return ChildPromocionQuery The current query, for fluid interface
     */
    public function prune($promocion = null)
    {
        if ($promocion) {
            $this->addUsingAlias(PromocionTableMap::ID_PROMOCION, $promocion->getIdPromocion(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the promocion table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PromocionTableMap::DATABASE_NAME);
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
            PromocionTableMap::clearInstancePool();
            PromocionTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildPromocion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildPromocion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PromocionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PromocionTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        PromocionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PromocionTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // PromocionQuery
