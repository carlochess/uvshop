<?php

namespace Base;

use \Imagen as ChildImagen;
use \ImagenQuery as ChildImagenQuery;
use \Exception;
use \PDO;
use Map\ImagenTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'imagen' table.
 *
 *
 *
 * @method     ChildImagenQuery orderByIdImagen($order = Criteria::ASC) Order by the id_imagen column
 * @method     ChildImagenQuery orderByIdProd($order = Criteria::ASC) Order by the id_prod column
 * @method     ChildImagenQuery orderByRuta($order = Criteria::ASC) Order by the ruta column
 * @method     ChildImagenQuery orderByAncho($order = Criteria::ASC) Order by the ancho column
 * @method     ChildImagenQuery orderByLargo($order = Criteria::ASC) Order by the largo column
 * @method     ChildImagenQuery orderByExtension($order = Criteria::ASC) Order by the extension column
 *
 * @method     ChildImagenQuery groupByIdImagen() Group by the id_imagen column
 * @method     ChildImagenQuery groupByIdProd() Group by the id_prod column
 * @method     ChildImagenQuery groupByRuta() Group by the ruta column
 * @method     ChildImagenQuery groupByAncho() Group by the ancho column
 * @method     ChildImagenQuery groupByLargo() Group by the largo column
 * @method     ChildImagenQuery groupByExtension() Group by the extension column
 *
 * @method     ChildImagenQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildImagenQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildImagenQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildImagenQuery leftJoinProducto($relationAlias = null) Adds a LEFT JOIN clause to the query using the Producto relation
 * @method     ChildImagenQuery rightJoinProducto($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Producto relation
 * @method     ChildImagenQuery innerJoinProducto($relationAlias = null) Adds a INNER JOIN clause to the query using the Producto relation
 *
 * @method     ChildImagen findOne(ConnectionInterface $con = null) Return the first ChildImagen matching the query
 * @method     ChildImagen findOneOrCreate(ConnectionInterface $con = null) Return the first ChildImagen matching the query, or a new ChildImagen object populated from the query conditions when no match is found
 *
 * @method     ChildImagen findOneByIdImagen(int $id_imagen) Return the first ChildImagen filtered by the id_imagen column
 * @method     ChildImagen findOneByIdProd(string $id_prod) Return the first ChildImagen filtered by the id_prod column
 * @method     ChildImagen findOneByRuta(string $ruta) Return the first ChildImagen filtered by the ruta column
 * @method     ChildImagen findOneByAncho(int $ancho) Return the first ChildImagen filtered by the ancho column
 * @method     ChildImagen findOneByLargo(int $largo) Return the first ChildImagen filtered by the largo column
 * @method     ChildImagen findOneByExtension(string $extension) Return the first ChildImagen filtered by the extension column
 *
 * @method     array findByIdImagen(int $id_imagen) Return ChildImagen objects filtered by the id_imagen column
 * @method     array findByIdProd(string $id_prod) Return ChildImagen objects filtered by the id_prod column
 * @method     array findByRuta(string $ruta) Return ChildImagen objects filtered by the ruta column
 * @method     array findByAncho(int $ancho) Return ChildImagen objects filtered by the ancho column
 * @method     array findByLargo(int $largo) Return ChildImagen objects filtered by the largo column
 * @method     array findByExtension(string $extension) Return ChildImagen objects filtered by the extension column
 *
 */
abstract class ImagenQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\ImagenQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'uvshop', $modelName = '\\Imagen', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildImagenQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildImagenQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \ImagenQuery) {
            return $criteria;
        }
        $query = new \ImagenQuery();
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
     * @return ChildImagen|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ImagenTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ImagenTableMap::DATABASE_NAME);
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
     * @return   ChildImagen A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID_IMAGEN, ID_PROD, RUTA, ANCHO, LARGO, EXTENSION FROM imagen WHERE ID_IMAGEN = :p0';
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
            $obj = new ChildImagen();
            $obj->hydrate($row);
            ImagenTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildImagen|array|mixed the result, formatted by the current formatter
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
     * @return ChildImagenQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ImagenTableMap::ID_IMAGEN, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildImagenQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ImagenTableMap::ID_IMAGEN, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_imagen column
     *
     * Example usage:
     * <code>
     * $query->filterByIdImagen(1234); // WHERE id_imagen = 1234
     * $query->filterByIdImagen(array(12, 34)); // WHERE id_imagen IN (12, 34)
     * $query->filterByIdImagen(array('min' => 12)); // WHERE id_imagen > 12
     * </code>
     *
     * @param     mixed $idImagen The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildImagenQuery The current query, for fluid interface
     */
    public function filterByIdImagen($idImagen = null, $comparison = null)
    {
        if (is_array($idImagen)) {
            $useMinMax = false;
            if (isset($idImagen['min'])) {
                $this->addUsingAlias(ImagenTableMap::ID_IMAGEN, $idImagen['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idImagen['max'])) {
                $this->addUsingAlias(ImagenTableMap::ID_IMAGEN, $idImagen['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ImagenTableMap::ID_IMAGEN, $idImagen, $comparison);
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
     * @return ChildImagenQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ImagenTableMap::ID_PROD, $idProd, $comparison);
    }

    /**
     * Filter the query on the ruta column
     *
     * Example usage:
     * <code>
     * $query->filterByRuta('fooValue');   // WHERE ruta = 'fooValue'
     * $query->filterByRuta('%fooValue%'); // WHERE ruta LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ruta The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildImagenQuery The current query, for fluid interface
     */
    public function filterByRuta($ruta = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ruta)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $ruta)) {
                $ruta = str_replace('*', '%', $ruta);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ImagenTableMap::RUTA, $ruta, $comparison);
    }

    /**
     * Filter the query on the ancho column
     *
     * Example usage:
     * <code>
     * $query->filterByAncho(1234); // WHERE ancho = 1234
     * $query->filterByAncho(array(12, 34)); // WHERE ancho IN (12, 34)
     * $query->filterByAncho(array('min' => 12)); // WHERE ancho > 12
     * </code>
     *
     * @param     mixed $ancho The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildImagenQuery The current query, for fluid interface
     */
    public function filterByAncho($ancho = null, $comparison = null)
    {
        if (is_array($ancho)) {
            $useMinMax = false;
            if (isset($ancho['min'])) {
                $this->addUsingAlias(ImagenTableMap::ANCHO, $ancho['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ancho['max'])) {
                $this->addUsingAlias(ImagenTableMap::ANCHO, $ancho['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ImagenTableMap::ANCHO, $ancho, $comparison);
    }

    /**
     * Filter the query on the largo column
     *
     * Example usage:
     * <code>
     * $query->filterByLargo(1234); // WHERE largo = 1234
     * $query->filterByLargo(array(12, 34)); // WHERE largo IN (12, 34)
     * $query->filterByLargo(array('min' => 12)); // WHERE largo > 12
     * </code>
     *
     * @param     mixed $largo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildImagenQuery The current query, for fluid interface
     */
    public function filterByLargo($largo = null, $comparison = null)
    {
        if (is_array($largo)) {
            $useMinMax = false;
            if (isset($largo['min'])) {
                $this->addUsingAlias(ImagenTableMap::LARGO, $largo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($largo['max'])) {
                $this->addUsingAlias(ImagenTableMap::LARGO, $largo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ImagenTableMap::LARGO, $largo, $comparison);
    }

    /**
     * Filter the query on the extension column
     *
     * Example usage:
     * <code>
     * $query->filterByExtension('fooValue');   // WHERE extension = 'fooValue'
     * $query->filterByExtension('%fooValue%'); // WHERE extension LIKE '%fooValue%'
     * </code>
     *
     * @param     string $extension The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildImagenQuery The current query, for fluid interface
     */
    public function filterByExtension($extension = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($extension)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $extension)) {
                $extension = str_replace('*', '%', $extension);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ImagenTableMap::EXTENSION, $extension, $comparison);
    }

    /**
     * Filter the query by a related \Producto object
     *
     * @param \Producto|ObjectCollection $producto The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildImagenQuery The current query, for fluid interface
     */
    public function filterByProducto($producto, $comparison = null)
    {
        if ($producto instanceof \Producto) {
            return $this
                ->addUsingAlias(ImagenTableMap::ID_PROD, $producto->getIdProd(), $comparison);
        } elseif ($producto instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ImagenTableMap::ID_PROD, $producto->toKeyValue('PrimaryKey', 'IdProd'), $comparison);
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
     * @return ChildImagenQuery The current query, for fluid interface
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
     * @param   ChildImagen $imagen Object to remove from the list of results
     *
     * @return ChildImagenQuery The current query, for fluid interface
     */
    public function prune($imagen = null)
    {
        if ($imagen) {
            $this->addUsingAlias(ImagenTableMap::ID_IMAGEN, $imagen->getIdImagen(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the imagen table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ImagenTableMap::DATABASE_NAME);
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
            ImagenTableMap::clearInstancePool();
            ImagenTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildImagen or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildImagen object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ImagenTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ImagenTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        ImagenTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ImagenTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ImagenQuery
