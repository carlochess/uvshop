<?php

namespace Base;

use \Producto as ChildProducto;
use \ProductoQuery as ChildProductoQuery;
use \Exception;
use \PDO;
use Map\ProductoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'producto' table.
 *
 *
 *
 * @method     ChildProductoQuery orderByIdProd($order = Criteria::ASC) Order by the id_prod column
 * @method     ChildProductoQuery orderByNombre($order = Criteria::ASC) Order by the nombre column
 * @method     ChildProductoQuery orderByEmpresaFab($order = Criteria::ASC) Order by the empresa_fab column
 * @method     ChildProductoQuery orderByDescripcion($order = Criteria::ASC) Order by the descripcion column
 * @method     ChildProductoQuery orderByIva($order = Criteria::ASC) Order by the iva column
 * @method     ChildProductoQuery orderByCategoria($order = Criteria::ASC) Order by the categoria column
 * @method     ChildProductoQuery orderByUnidades($order = Criteria::ASC) Order by the unidades column
 *
 * @method     ChildProductoQuery groupByIdProd() Group by the id_prod column
 * @method     ChildProductoQuery groupByNombre() Group by the nombre column
 * @method     ChildProductoQuery groupByEmpresaFab() Group by the empresa_fab column
 * @method     ChildProductoQuery groupByDescripcion() Group by the descripcion column
 * @method     ChildProductoQuery groupByIva() Group by the iva column
 * @method     ChildProductoQuery groupByCategoria() Group by the categoria column
 * @method     ChildProductoQuery groupByUnidades() Group by the unidades column
 *
 * @method     ChildProductoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProductoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProductoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProductoQuery leftJoinFactura($relationAlias = null) Adds a LEFT JOIN clause to the query using the Factura relation
 * @method     ChildProductoQuery rightJoinFactura($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Factura relation
 * @method     ChildProductoQuery innerJoinFactura($relationAlias = null) Adds a INNER JOIN clause to the query using the Factura relation
 *
 * @method     ChildProductoQuery leftJoinImagen($relationAlias = null) Adds a LEFT JOIN clause to the query using the Imagen relation
 * @method     ChildProductoQuery rightJoinImagen($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Imagen relation
 * @method     ChildProductoQuery innerJoinImagen($relationAlias = null) Adds a INNER JOIN clause to the query using the Imagen relation
 *
 * @method     ChildProductoQuery leftJoinPrecio($relationAlias = null) Adds a LEFT JOIN clause to the query using the Precio relation
 * @method     ChildProductoQuery rightJoinPrecio($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Precio relation
 * @method     ChildProductoQuery innerJoinPrecio($relationAlias = null) Adds a INNER JOIN clause to the query using the Precio relation
 *
 * @method     ChildProductoQuery leftJoinPromocion($relationAlias = null) Adds a LEFT JOIN clause to the query using the Promocion relation
 * @method     ChildProductoQuery rightJoinPromocion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Promocion relation
 * @method     ChildProductoQuery innerJoinPromocion($relationAlias = null) Adds a INNER JOIN clause to the query using the Promocion relation
 *
 * @method     ChildProducto findOne(ConnectionInterface $con = null) Return the first ChildProducto matching the query
 * @method     ChildProducto findOneOrCreate(ConnectionInterface $con = null) Return the first ChildProducto matching the query, or a new ChildProducto object populated from the query conditions when no match is found
 *
 * @method     ChildProducto findOneByIdProd(string $id_prod) Return the first ChildProducto filtered by the id_prod column
 * @method     ChildProducto findOneByNombre(string $nombre) Return the first ChildProducto filtered by the nombre column
 * @method     ChildProducto findOneByEmpresaFab(string $empresa_fab) Return the first ChildProducto filtered by the empresa_fab column
 * @method     ChildProducto findOneByDescripcion(string $descripcion) Return the first ChildProducto filtered by the descripcion column
 * @method     ChildProducto findOneByIva(int $iva) Return the first ChildProducto filtered by the iva column
 * @method     ChildProducto findOneByCategoria(string $categoria) Return the first ChildProducto filtered by the categoria column
 * @method     ChildProducto findOneByUnidades(int $unidades) Return the first ChildProducto filtered by the unidades column
 *
 * @method     array findByIdProd(string $id_prod) Return ChildProducto objects filtered by the id_prod column
 * @method     array findByNombre(string $nombre) Return ChildProducto objects filtered by the nombre column
 * @method     array findByEmpresaFab(string $empresa_fab) Return ChildProducto objects filtered by the empresa_fab column
 * @method     array findByDescripcion(string $descripcion) Return ChildProducto objects filtered by the descripcion column
 * @method     array findByIva(int $iva) Return ChildProducto objects filtered by the iva column
 * @method     array findByCategoria(string $categoria) Return ChildProducto objects filtered by the categoria column
 * @method     array findByUnidades(int $unidades) Return ChildProducto objects filtered by the unidades column
 *
 */
abstract class ProductoQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \Base\ProductoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'uvshop', $modelName = '\\Producto', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProductoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildProductoQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \ProductoQuery) {
            return $criteria;
        }
        $query = new \ProductoQuery();
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
     * @return ChildProducto|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProductoTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProductoTableMap::DATABASE_NAME);
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
     * @return   ChildProducto A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT ID_PROD, NOMBRE, EMPRESA_FAB, DESCRIPCION, IVA, CATEGORIA, UNIDADES FROM producto WHERE ID_PROD = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildProducto();
            $obj->hydrate($row);
            ProductoTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildProducto|array|mixed the result, formatted by the current formatter
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
     * @return ChildProductoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProductoTableMap::ID_PROD, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildProductoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProductoTableMap::ID_PROD, $keys, Criteria::IN);
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
     * @return ChildProductoQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProductoTableMap::ID_PROD, $idProd, $comparison);
    }

    /**
     * Filter the query on the nombre column
     *
     * Example usage:
     * <code>
     * $query->filterByNombre('fooValue');   // WHERE nombre = 'fooValue'
     * $query->filterByNombre('%fooValue%'); // WHERE nombre LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nombre The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductoQuery The current query, for fluid interface
     */
    public function filterByNombre($nombre = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nombre)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nombre)) {
                $nombre = str_replace('*', '%', $nombre);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProductoTableMap::NOMBRE, $nombre, $comparison);
    }

    /**
     * Filter the query on the empresa_fab column
     *
     * Example usage:
     * <code>
     * $query->filterByEmpresaFab('fooValue');   // WHERE empresa_fab = 'fooValue'
     * $query->filterByEmpresaFab('%fooValue%'); // WHERE empresa_fab LIKE '%fooValue%'
     * </code>
     *
     * @param     string $empresaFab The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductoQuery The current query, for fluid interface
     */
    public function filterByEmpresaFab($empresaFab = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($empresaFab)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $empresaFab)) {
                $empresaFab = str_replace('*', '%', $empresaFab);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProductoTableMap::EMPRESA_FAB, $empresaFab, $comparison);
    }

    /**
     * Filter the query on the descripcion column
     *
     * Example usage:
     * <code>
     * $query->filterByDescripcion('fooValue');   // WHERE descripcion = 'fooValue'
     * $query->filterByDescripcion('%fooValue%'); // WHERE descripcion LIKE '%fooValue%'
     * </code>
     *
     * @param     string $descripcion The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductoQuery The current query, for fluid interface
     */
    public function filterByDescripcion($descripcion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($descripcion)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $descripcion)) {
                $descripcion = str_replace('*', '%', $descripcion);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProductoTableMap::DESCRIPCION, $descripcion, $comparison);
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
     * @return ChildProductoQuery The current query, for fluid interface
     */
    public function filterByIva($iva = null, $comparison = null)
    {
        if (is_array($iva)) {
            $useMinMax = false;
            if (isset($iva['min'])) {
                $this->addUsingAlias(ProductoTableMap::IVA, $iva['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($iva['max'])) {
                $this->addUsingAlias(ProductoTableMap::IVA, $iva['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductoTableMap::IVA, $iva, $comparison);
    }

    /**
     * Filter the query on the categoria column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoria('fooValue');   // WHERE categoria = 'fooValue'
     * $query->filterByCategoria('%fooValue%'); // WHERE categoria LIKE '%fooValue%'
     * </code>
     *
     * @param     string $categoria The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductoQuery The current query, for fluid interface
     */
    public function filterByCategoria($categoria = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($categoria)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $categoria)) {
                $categoria = str_replace('*', '%', $categoria);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProductoTableMap::CATEGORIA, $categoria, $comparison);
    }

    /**
     * Filter the query on the unidades column
     *
     * Example usage:
     * <code>
     * $query->filterByUnidades(1234); // WHERE unidades = 1234
     * $query->filterByUnidades(array(12, 34)); // WHERE unidades IN (12, 34)
     * $query->filterByUnidades(array('min' => 12)); // WHERE unidades > 12
     * </code>
     *
     * @param     mixed $unidades The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductoQuery The current query, for fluid interface
     */
    public function filterByUnidades($unidades = null, $comparison = null)
    {
        if (is_array($unidades)) {
            $useMinMax = false;
            if (isset($unidades['min'])) {
                $this->addUsingAlias(ProductoTableMap::UNIDADES, $unidades['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($unidades['max'])) {
                $this->addUsingAlias(ProductoTableMap::UNIDADES, $unidades['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductoTableMap::UNIDADES, $unidades, $comparison);
    }

    /**
     * Filter the query by a related \Factura object
     *
     * @param \Factura|ObjectCollection $factura  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductoQuery The current query, for fluid interface
     */
    public function filterByFactura($factura, $comparison = null)
    {
        if ($factura instanceof \Factura) {
            return $this
                ->addUsingAlias(ProductoTableMap::ID_PROD, $factura->getIdCliente(), $comparison);
        } elseif ($factura instanceof ObjectCollection) {
            return $this
                ->useFacturaQuery()
                ->filterByPrimaryKeys($factura->getPrimaryKeys())
                ->endUse();
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
     * @return ChildProductoQuery The current query, for fluid interface
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
     * Filter the query by a related \Imagen object
     *
     * @param \Imagen|ObjectCollection $imagen  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductoQuery The current query, for fluid interface
     */
    public function filterByImagen($imagen, $comparison = null)
    {
        if ($imagen instanceof \Imagen) {
            return $this
                ->addUsingAlias(ProductoTableMap::ID_PROD, $imagen->getIdProd(), $comparison);
        } elseif ($imagen instanceof ObjectCollection) {
            return $this
                ->useImagenQuery()
                ->filterByPrimaryKeys($imagen->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByImagen() only accepts arguments of type \Imagen or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Imagen relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildProductoQuery The current query, for fluid interface
     */
    public function joinImagen($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Imagen');

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
            $this->addJoinObject($join, 'Imagen');
        }

        return $this;
    }

    /**
     * Use the Imagen relation Imagen object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \ImagenQuery A secondary query class using the current class as primary query
     */
    public function useImagenQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinImagen($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Imagen', '\ImagenQuery');
    }

    /**
     * Filter the query by a related \Precio object
     *
     * @param \Precio|ObjectCollection $precio  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductoQuery The current query, for fluid interface
     */
    public function filterByPrecio($precio, $comparison = null)
    {
        if ($precio instanceof \Precio) {
            return $this
                ->addUsingAlias(ProductoTableMap::ID_PROD, $precio->getCodProducto(), $comparison);
        } elseif ($precio instanceof ObjectCollection) {
            return $this
                ->usePrecioQuery()
                ->filterByPrimaryKeys($precio->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPrecio() only accepts arguments of type \Precio or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Precio relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildProductoQuery The current query, for fluid interface
     */
    public function joinPrecio($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Precio');

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
            $this->addJoinObject($join, 'Precio');
        }

        return $this;
    }

    /**
     * Use the Precio relation Precio object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PrecioQuery A secondary query class using the current class as primary query
     */
    public function usePrecioQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPrecio($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Precio', '\PrecioQuery');
    }

    /**
     * Filter the query by a related \Promocion object
     *
     * @param \Promocion|ObjectCollection $promocion  the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductoQuery The current query, for fluid interface
     */
    public function filterByPromocion($promocion, $comparison = null)
    {
        if ($promocion instanceof \Promocion) {
            return $this
                ->addUsingAlias(ProductoTableMap::ID_PROD, $promocion->getCodProducto(), $comparison);
        } elseif ($promocion instanceof ObjectCollection) {
            return $this
                ->usePromocionQuery()
                ->filterByPrimaryKeys($promocion->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPromocion() only accepts arguments of type \Promocion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Promocion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildProductoQuery The current query, for fluid interface
     */
    public function joinPromocion($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Promocion');

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
            $this->addJoinObject($join, 'Promocion');
        }

        return $this;
    }

    /**
     * Use the Promocion relation Promocion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \PromocionQuery A secondary query class using the current class as primary query
     */
    public function usePromocionQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPromocion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Promocion', '\PromocionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildProducto $producto Object to remove from the list of results
     *
     * @return ChildProductoQuery The current query, for fluid interface
     */
    public function prune($producto = null)
    {
        if ($producto) {
            $this->addUsingAlias(ProductoTableMap::ID_PROD, $producto->getIdProd(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the producto table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductoTableMap::DATABASE_NAME);
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
            ProductoTableMap::clearInstancePool();
            ProductoTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildProducto or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildProducto object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ProductoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProductoTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        ProductoTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ProductoTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ProductoQuery
