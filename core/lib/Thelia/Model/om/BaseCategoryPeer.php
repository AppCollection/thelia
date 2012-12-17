<?php

namespace Thelia\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Thelia\Model\AttributeCategoryPeer;
use Thelia\Model\Category;
use Thelia\Model\CategoryDescPeer;
use Thelia\Model\CategoryPeer;
use Thelia\Model\ContentAssocPeer;
use Thelia\Model\DocumentPeer;
use Thelia\Model\FeatureCategoryPeer;
use Thelia\Model\ImagePeer;
use Thelia\Model\ProductCategoryPeer;
use Thelia\Model\RewritingPeer;
use Thelia\Model\map\CategoryTableMap;

/**
 * Base static class for performing query and update operations on the 'category' table.
 *
 *
 *
 * @package propel.generator.Thelia.Model.om
 */
abstract class BaseCategoryPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'mydb';

    /** the table name for this class */
    const TABLE_NAME = 'category';

    /** the related Propel class for this table */
    const OM_CLASS = 'Thelia\\Model\\Category';

    /** the related TableMap class for this table */
    const TM_CLASS = 'CategoryTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 7;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 7;

    /** the column name for the ID field */
    const ID = 'category.ID';

    /** the column name for the PARENT field */
    const PARENT = 'category.PARENT';

    /** the column name for the LINK field */
    const LINK = 'category.LINK';

    /** the column name for the VISIBLE field */
    const VISIBLE = 'category.VISIBLE';

    /** the column name for the POSITION field */
    const POSITION = 'category.POSITION';

    /** the column name for the CREATED_AT field */
    const CREATED_AT = 'category.CREATED_AT';

    /** the column name for the UPDATED_AT field */
    const UPDATED_AT = 'category.UPDATED_AT';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identiy map to hold any loaded instances of Category objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Category[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. CategoryPeer::$fieldNames[CategoryPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'Parent', 'Link', 'Visible', 'Position', 'CreatedAt', 'UpdatedAt', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'parent', 'link', 'visible', 'position', 'createdAt', 'updatedAt', ),
        BasePeer::TYPE_COLNAME => array (CategoryPeer::ID, CategoryPeer::PARENT, CategoryPeer::LINK, CategoryPeer::VISIBLE, CategoryPeer::POSITION, CategoryPeer::CREATED_AT, CategoryPeer::UPDATED_AT, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'PARENT', 'LINK', 'VISIBLE', 'POSITION', 'CREATED_AT', 'UPDATED_AT', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'parent', 'link', 'visible', 'position', 'created_at', 'updated_at', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. CategoryPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Parent' => 1, 'Link' => 2, 'Visible' => 3, 'Position' => 4, 'CreatedAt' => 5, 'UpdatedAt' => 6, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'parent' => 1, 'link' => 2, 'visible' => 3, 'position' => 4, 'createdAt' => 5, 'updatedAt' => 6, ),
        BasePeer::TYPE_COLNAME => array (CategoryPeer::ID => 0, CategoryPeer::PARENT => 1, CategoryPeer::LINK => 2, CategoryPeer::VISIBLE => 3, CategoryPeer::POSITION => 4, CategoryPeer::CREATED_AT => 5, CategoryPeer::UPDATED_AT => 6, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'PARENT' => 1, 'LINK' => 2, 'VISIBLE' => 3, 'POSITION' => 4, 'CREATED_AT' => 5, 'UPDATED_AT' => 6, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'parent' => 1, 'link' => 2, 'visible' => 3, 'position' => 4, 'created_at' => 5, 'updated_at' => 6, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * Translates a fieldname to another type
     *
     * @param      string $name field name
     * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @param      string $toType   One of the class type constants
     * @return string          translated name of the field.
     * @throws PropelException - if the specified name could not be found in the fieldname mappings.
     */
    public static function translateFieldName($name, $fromType, $toType)
    {
        $toNames = CategoryPeer::getFieldNames($toType);
        $key = isset(CategoryPeer::$fieldKeys[$fromType][$name]) ? CategoryPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(CategoryPeer::$fieldKeys[$fromType], true));
        }

        return $toNames[$key];
    }

    /**
     * Returns an array of field names.
     *
     * @param      string $type The type of fieldnames to return:
     *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return array           A list of field names
     * @throws PropelException - if the type is not valid.
     */
    public static function getFieldNames($type = BasePeer::TYPE_PHPNAME)
    {
        if (!array_key_exists($type, CategoryPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return CategoryPeer::$fieldNames[$type];
    }

    /**
     * Convenience method which changes table.column to alias.column.
     *
     * Using this method you can maintain SQL abstraction while using column aliases.
     * <code>
     *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
     *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
     * </code>
     * @param      string $alias The alias for the current table.
     * @param      string $column The column name for current table. (i.e. CategoryPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(CategoryPeer::TABLE_NAME.'.', $alias.'.', $column);
    }

    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param      Criteria $criteria object containing the columns to add.
     * @param      string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(CategoryPeer::ID);
            $criteria->addSelectColumn(CategoryPeer::PARENT);
            $criteria->addSelectColumn(CategoryPeer::LINK);
            $criteria->addSelectColumn(CategoryPeer::VISIBLE);
            $criteria->addSelectColumn(CategoryPeer::POSITION);
            $criteria->addSelectColumn(CategoryPeer::CREATED_AT);
            $criteria->addSelectColumn(CategoryPeer::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.ID');
            $criteria->addSelectColumn($alias . '.PARENT');
            $criteria->addSelectColumn($alias . '.LINK');
            $criteria->addSelectColumn($alias . '.VISIBLE');
            $criteria->addSelectColumn($alias . '.POSITION');
            $criteria->addSelectColumn($alias . '.CREATED_AT');
            $criteria->addSelectColumn($alias . '.UPDATED_AT');
        }
    }

    /**
     * Returns the number of rows matching criteria.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @return int Number of matching rows.
     */
    public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
    {
        // we may modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(CategoryPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        // BasePeer returns a PDOStatement
        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }
    /**
     * Selects one object from the DB.
     *
     * @param      Criteria $criteria object used to create the SELECT statement.
     * @param      PropelPDO $con
     * @return                 Category
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = CategoryPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }
    /**
     * Selects several row from the DB.
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con
     * @return array           Array of selected Objects
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return CategoryPeer::populateObjects(CategoryPeer::doSelectStmt($criteria, $con));
    }
    /**
     * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
     *
     * Use this method directly if you want to work with an executed statement durirectly (for example
     * to perform your own object hydration).
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con The connection to use
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return PDOStatement The executed PDOStatement object.
     * @see        BasePeer::doSelect()
     */
    public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            CategoryPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        // BasePeer returns a PDOStatement
        return BasePeer::doSelect($criteria, $con);
    }
    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doSelect*()
     * methods in your stub classes -- you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by doSelect*()
     * and retrieveByPK*() calls.
     *
     * @param      Category $obj A Category object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            CategoryPeer::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param      mixed $value A Category object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Category) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Category object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(CategoryPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return   Category Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(CategoryPeer::$instances[$key])) {
                return CategoryPeer::$instances[$key];
            }
        }

        return null; // just to be explicit
    }

    /**
     * Clear the instance pool.
     *
     * @return void
     */
    public static function clearInstancePool()
    {
        CategoryPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to category
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return string A string version of PK or null if the components of primary key in result array are all null.
     */
    public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
    {
        // If the PK cannot be derived from the row, return null.
        if ($row[$startcol] === null) {
            return null;
        }

        return (string) $row[$startcol];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $startcol = 0)
    {

        return (int) $row[$startcol];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function populateObjects(PDOStatement $stmt)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = CategoryPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = CategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = CategoryPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CategoryPeer::addInstanceToPool($obj, $key);
            } // if key exists
        }
        $stmt->closeCursor();

        return $results;
    }
    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return array (Category object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = CategoryPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = CategoryPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + CategoryPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CategoryPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            CategoryPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related AttributeCategory table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAttributeCategory(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CategoryPeer::ID, AttributeCategoryPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related CategoryDesc table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinCategoryDesc(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CategoryPeer::ID, CategoryDescPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related ContentAssoc table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinContentAssoc(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CategoryPeer::ID, ContentAssocPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Document table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinDocument(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CategoryPeer::ID, DocumentPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related FeatureCategory table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinFeatureCategory(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CategoryPeer::ID, FeatureCategoryPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Image table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinImage(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CategoryPeer::ID, ImagePeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related ProductCategory table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinProductCategory(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CategoryPeer::ID, ProductCategoryPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Rewriting table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinRewriting(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CategoryPeer::ID, RewritingPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of Category objects pre-filled with their AttributeCategory objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Category objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAttributeCategory(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CategoryPeer::DATABASE_NAME);
        }

        CategoryPeer::addSelectColumns($criteria);
        $startcol = CategoryPeer::NUM_HYDRATE_COLUMNS;
        AttributeCategoryPeer::addSelectColumns($criteria);

        $criteria->addJoin(CategoryPeer::ID, AttributeCategoryPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CategoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = CategoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CategoryPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = AttributeCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = AttributeCategoryPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AttributeCategoryPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    AttributeCategoryPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Category) to $obj2 (AttributeCategory)
                // one to one relationship
                $obj1->setAttributeCategory($obj2);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Category objects pre-filled with their CategoryDesc objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Category objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinCategoryDesc(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CategoryPeer::DATABASE_NAME);
        }

        CategoryPeer::addSelectColumns($criteria);
        $startcol = CategoryPeer::NUM_HYDRATE_COLUMNS;
        CategoryDescPeer::addSelectColumns($criteria);

        $criteria->addJoin(CategoryPeer::ID, CategoryDescPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CategoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = CategoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CategoryPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = CategoryDescPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = CategoryDescPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = CategoryDescPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    CategoryDescPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Category) to $obj2 (CategoryDesc)
                // one to one relationship
                $obj1->setCategoryDesc($obj2);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Category objects pre-filled with their ContentAssoc objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Category objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinContentAssoc(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CategoryPeer::DATABASE_NAME);
        }

        CategoryPeer::addSelectColumns($criteria);
        $startcol = CategoryPeer::NUM_HYDRATE_COLUMNS;
        ContentAssocPeer::addSelectColumns($criteria);

        $criteria->addJoin(CategoryPeer::ID, ContentAssocPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CategoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = CategoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CategoryPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = ContentAssocPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = ContentAssocPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = ContentAssocPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    ContentAssocPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Category) to $obj2 (ContentAssoc)
                // one to one relationship
                $obj1->setContentAssoc($obj2);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Category objects pre-filled with their Document objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Category objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinDocument(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CategoryPeer::DATABASE_NAME);
        }

        CategoryPeer::addSelectColumns($criteria);
        $startcol = CategoryPeer::NUM_HYDRATE_COLUMNS;
        DocumentPeer::addSelectColumns($criteria);

        $criteria->addJoin(CategoryPeer::ID, DocumentPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CategoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = CategoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CategoryPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = DocumentPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = DocumentPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = DocumentPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    DocumentPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Category) to $obj2 (Document)
                // one to one relationship
                $obj1->setDocument($obj2);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Category objects pre-filled with their FeatureCategory objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Category objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinFeatureCategory(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CategoryPeer::DATABASE_NAME);
        }

        CategoryPeer::addSelectColumns($criteria);
        $startcol = CategoryPeer::NUM_HYDRATE_COLUMNS;
        FeatureCategoryPeer::addSelectColumns($criteria);

        $criteria->addJoin(CategoryPeer::ID, FeatureCategoryPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CategoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = CategoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CategoryPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = FeatureCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = FeatureCategoryPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = FeatureCategoryPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    FeatureCategoryPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Category) to $obj2 (FeatureCategory)
                // one to one relationship
                $obj1->setFeatureCategory($obj2);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Category objects pre-filled with their Image objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Category objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinImage(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CategoryPeer::DATABASE_NAME);
        }

        CategoryPeer::addSelectColumns($criteria);
        $startcol = CategoryPeer::NUM_HYDRATE_COLUMNS;
        ImagePeer::addSelectColumns($criteria);

        $criteria->addJoin(CategoryPeer::ID, ImagePeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CategoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = CategoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CategoryPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = ImagePeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = ImagePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = ImagePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    ImagePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Category) to $obj2 (Image)
                // one to one relationship
                $obj1->setImage($obj2);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Category objects pre-filled with their ProductCategory objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Category objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinProductCategory(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CategoryPeer::DATABASE_NAME);
        }

        CategoryPeer::addSelectColumns($criteria);
        $startcol = CategoryPeer::NUM_HYDRATE_COLUMNS;
        ProductCategoryPeer::addSelectColumns($criteria);

        $criteria->addJoin(CategoryPeer::ID, ProductCategoryPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CategoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = CategoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CategoryPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = ProductCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = ProductCategoryPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = ProductCategoryPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    ProductCategoryPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Category) to $obj2 (ProductCategory)
                // one to one relationship
                $obj1->setProductCategory($obj2);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Category objects pre-filled with their Rewriting objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Category objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinRewriting(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CategoryPeer::DATABASE_NAME);
        }

        CategoryPeer::addSelectColumns($criteria);
        $startcol = CategoryPeer::NUM_HYDRATE_COLUMNS;
        RewritingPeer::addSelectColumns($criteria);

        $criteria->addJoin(CategoryPeer::ID, RewritingPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CategoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = CategoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CategoryPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = RewritingPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = RewritingPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = RewritingPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    RewritingPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Category) to $obj2 (Rewriting)
                // one to one relationship
                $obj1->setRewriting($obj2);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining all related tables
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CategoryPeer::ID, AttributeCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, CategoryDescPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ContentAssocPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, DocumentPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, FeatureCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ImagePeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ProductCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, RewritingPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }

    /**
     * Selects a collection of Category objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Category objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CategoryPeer::DATABASE_NAME);
        }

        CategoryPeer::addSelectColumns($criteria);
        $startcol2 = CategoryPeer::NUM_HYDRATE_COLUMNS;

        AttributeCategoryPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AttributeCategoryPeer::NUM_HYDRATE_COLUMNS;

        CategoryDescPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + CategoryDescPeer::NUM_HYDRATE_COLUMNS;

        ContentAssocPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ContentAssocPeer::NUM_HYDRATE_COLUMNS;

        DocumentPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + DocumentPeer::NUM_HYDRATE_COLUMNS;

        FeatureCategoryPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + FeatureCategoryPeer::NUM_HYDRATE_COLUMNS;

        ImagePeer::addSelectColumns($criteria);
        $startcol8 = $startcol7 + ImagePeer::NUM_HYDRATE_COLUMNS;

        ProductCategoryPeer::addSelectColumns($criteria);
        $startcol9 = $startcol8 + ProductCategoryPeer::NUM_HYDRATE_COLUMNS;

        RewritingPeer::addSelectColumns($criteria);
        $startcol10 = $startcol9 + RewritingPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(CategoryPeer::ID, AttributeCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, CategoryDescPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ContentAssocPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, DocumentPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, FeatureCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ImagePeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ProductCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, RewritingPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CategoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = CategoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CategoryPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined AttributeCategory rows

            $key2 = AttributeCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = AttributeCategoryPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AttributeCategoryPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AttributeCategoryPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (Category) to the collection in $obj2 (AttributeCategory)
                $obj1->setAttributeCategory($obj2);
            } // if joined row not null

            // Add objects for joined CategoryDesc rows

            $key3 = CategoryDescPeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = CategoryDescPeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = CategoryDescPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    CategoryDescPeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (Category) to the collection in $obj3 (CategoryDesc)
                $obj1->setCategoryDesc($obj3);
            } // if joined row not null

            // Add objects for joined ContentAssoc rows

            $key4 = ContentAssocPeer::getPrimaryKeyHashFromRow($row, $startcol4);
            if ($key4 !== null) {
                $obj4 = ContentAssocPeer::getInstanceFromPool($key4);
                if (!$obj4) {

                    $cls = ContentAssocPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ContentAssocPeer::addInstanceToPool($obj4, $key4);
                } // if obj4 loaded

                // Add the $obj1 (Category) to the collection in $obj4 (ContentAssoc)
                $obj1->setContentAssoc($obj4);
            } // if joined row not null

            // Add objects for joined Document rows

            $key5 = DocumentPeer::getPrimaryKeyHashFromRow($row, $startcol5);
            if ($key5 !== null) {
                $obj5 = DocumentPeer::getInstanceFromPool($key5);
                if (!$obj5) {

                    $cls = DocumentPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    DocumentPeer::addInstanceToPool($obj5, $key5);
                } // if obj5 loaded

                // Add the $obj1 (Category) to the collection in $obj5 (Document)
                $obj1->setDocument($obj5);
            } // if joined row not null

            // Add objects for joined FeatureCategory rows

            $key6 = FeatureCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol6);
            if ($key6 !== null) {
                $obj6 = FeatureCategoryPeer::getInstanceFromPool($key6);
                if (!$obj6) {

                    $cls = FeatureCategoryPeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    FeatureCategoryPeer::addInstanceToPool($obj6, $key6);
                } // if obj6 loaded

                // Add the $obj1 (Category) to the collection in $obj6 (FeatureCategory)
                $obj1->setFeatureCategory($obj6);
            } // if joined row not null

            // Add objects for joined Image rows

            $key7 = ImagePeer::getPrimaryKeyHashFromRow($row, $startcol7);
            if ($key7 !== null) {
                $obj7 = ImagePeer::getInstanceFromPool($key7);
                if (!$obj7) {

                    $cls = ImagePeer::getOMClass();

                    $obj7 = new $cls();
                    $obj7->hydrate($row, $startcol7);
                    ImagePeer::addInstanceToPool($obj7, $key7);
                } // if obj7 loaded

                // Add the $obj1 (Category) to the collection in $obj7 (Image)
                $obj1->setImage($obj7);
            } // if joined row not null

            // Add objects for joined ProductCategory rows

            $key8 = ProductCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol8);
            if ($key8 !== null) {
                $obj8 = ProductCategoryPeer::getInstanceFromPool($key8);
                if (!$obj8) {

                    $cls = ProductCategoryPeer::getOMClass();

                    $obj8 = new $cls();
                    $obj8->hydrate($row, $startcol8);
                    ProductCategoryPeer::addInstanceToPool($obj8, $key8);
                } // if obj8 loaded

                // Add the $obj1 (Category) to the collection in $obj8 (ProductCategory)
                $obj1->setProductCategory($obj8);
            } // if joined row not null

            // Add objects for joined Rewriting rows

            $key9 = RewritingPeer::getPrimaryKeyHashFromRow($row, $startcol9);
            if ($key9 !== null) {
                $obj9 = RewritingPeer::getInstanceFromPool($key9);
                if (!$obj9) {

                    $cls = RewritingPeer::getOMClass();

                    $obj9 = new $cls();
                    $obj9->hydrate($row, $startcol9);
                    RewritingPeer::addInstanceToPool($obj9, $key9);
                } // if obj9 loaded

                // Add the $obj1 (Category) to the collection in $obj9 (Rewriting)
                $obj1->setRewriting($obj9);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining the related AttributeCategory table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptAttributeCategory(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CategoryPeer::ID, CategoryDescPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ContentAssocPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, DocumentPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, FeatureCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ImagePeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ProductCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, RewritingPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related CategoryDesc table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptCategoryDesc(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CategoryPeer::ID, AttributeCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ContentAssocPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, DocumentPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, FeatureCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ImagePeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ProductCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, RewritingPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related ContentAssoc table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptContentAssoc(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CategoryPeer::ID, AttributeCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, CategoryDescPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, DocumentPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, FeatureCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ImagePeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ProductCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, RewritingPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Document table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptDocument(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CategoryPeer::ID, AttributeCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, CategoryDescPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ContentAssocPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, FeatureCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ImagePeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ProductCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, RewritingPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related FeatureCategory table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptFeatureCategory(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CategoryPeer::ID, AttributeCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, CategoryDescPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ContentAssocPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, DocumentPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ImagePeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ProductCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, RewritingPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Image table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptImage(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CategoryPeer::ID, AttributeCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, CategoryDescPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ContentAssocPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, DocumentPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, FeatureCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ProductCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, RewritingPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related ProductCategory table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptProductCategory(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CategoryPeer::ID, AttributeCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, CategoryDescPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ContentAssocPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, DocumentPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, FeatureCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ImagePeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, RewritingPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Rewriting table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptRewriting(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CategoryPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CategoryPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CategoryPeer::ID, AttributeCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, CategoryDescPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ContentAssocPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, DocumentPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, FeatureCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ImagePeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ProductCategoryPeer::CATEGORY_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of Category objects pre-filled with all related objects except AttributeCategory.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Category objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptAttributeCategory(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CategoryPeer::DATABASE_NAME);
        }

        CategoryPeer::addSelectColumns($criteria);
        $startcol2 = CategoryPeer::NUM_HYDRATE_COLUMNS;

        CategoryDescPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + CategoryDescPeer::NUM_HYDRATE_COLUMNS;

        ContentAssocPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + ContentAssocPeer::NUM_HYDRATE_COLUMNS;

        DocumentPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + DocumentPeer::NUM_HYDRATE_COLUMNS;

        FeatureCategoryPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + FeatureCategoryPeer::NUM_HYDRATE_COLUMNS;

        ImagePeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + ImagePeer::NUM_HYDRATE_COLUMNS;

        ProductCategoryPeer::addSelectColumns($criteria);
        $startcol8 = $startcol7 + ProductCategoryPeer::NUM_HYDRATE_COLUMNS;

        RewritingPeer::addSelectColumns($criteria);
        $startcol9 = $startcol8 + RewritingPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(CategoryPeer::ID, CategoryDescPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ContentAssocPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, DocumentPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, FeatureCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ImagePeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ProductCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, RewritingPeer::CATEGORY_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CategoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = CategoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CategoryPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined CategoryDesc rows

                $key2 = CategoryDescPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = CategoryDescPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = CategoryDescPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    CategoryDescPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Category) to the collection in $obj2 (CategoryDesc)
                $obj1->setCategoryDesc($obj2);

            } // if joined row is not null

                // Add objects for joined ContentAssoc rows

                $key3 = ContentAssocPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = ContentAssocPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = ContentAssocPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    ContentAssocPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Category) to the collection in $obj3 (ContentAssoc)
                $obj1->setContentAssoc($obj3);

            } // if joined row is not null

                // Add objects for joined Document rows

                $key4 = DocumentPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = DocumentPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = DocumentPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    DocumentPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Category) to the collection in $obj4 (Document)
                $obj1->setDocument($obj4);

            } // if joined row is not null

                // Add objects for joined FeatureCategory rows

                $key5 = FeatureCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = FeatureCategoryPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = FeatureCategoryPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    FeatureCategoryPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Category) to the collection in $obj5 (FeatureCategory)
                $obj1->setFeatureCategory($obj5);

            } // if joined row is not null

                // Add objects for joined Image rows

                $key6 = ImagePeer::getPrimaryKeyHashFromRow($row, $startcol6);
                if ($key6 !== null) {
                    $obj6 = ImagePeer::getInstanceFromPool($key6);
                    if (!$obj6) {

                        $cls = ImagePeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    ImagePeer::addInstanceToPool($obj6, $key6);
                } // if $obj6 already loaded

                // Add the $obj1 (Category) to the collection in $obj6 (Image)
                $obj1->setImage($obj6);

            } // if joined row is not null

                // Add objects for joined ProductCategory rows

                $key7 = ProductCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol7);
                if ($key7 !== null) {
                    $obj7 = ProductCategoryPeer::getInstanceFromPool($key7);
                    if (!$obj7) {

                        $cls = ProductCategoryPeer::getOMClass();

                    $obj7 = new $cls();
                    $obj7->hydrate($row, $startcol7);
                    ProductCategoryPeer::addInstanceToPool($obj7, $key7);
                } // if $obj7 already loaded

                // Add the $obj1 (Category) to the collection in $obj7 (ProductCategory)
                $obj1->setProductCategory($obj7);

            } // if joined row is not null

                // Add objects for joined Rewriting rows

                $key8 = RewritingPeer::getPrimaryKeyHashFromRow($row, $startcol8);
                if ($key8 !== null) {
                    $obj8 = RewritingPeer::getInstanceFromPool($key8);
                    if (!$obj8) {

                        $cls = RewritingPeer::getOMClass();

                    $obj8 = new $cls();
                    $obj8->hydrate($row, $startcol8);
                    RewritingPeer::addInstanceToPool($obj8, $key8);
                } // if $obj8 already loaded

                // Add the $obj1 (Category) to the collection in $obj8 (Rewriting)
                $obj1->setRewriting($obj8);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Category objects pre-filled with all related objects except CategoryDesc.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Category objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptCategoryDesc(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CategoryPeer::DATABASE_NAME);
        }

        CategoryPeer::addSelectColumns($criteria);
        $startcol2 = CategoryPeer::NUM_HYDRATE_COLUMNS;

        AttributeCategoryPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AttributeCategoryPeer::NUM_HYDRATE_COLUMNS;

        ContentAssocPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + ContentAssocPeer::NUM_HYDRATE_COLUMNS;

        DocumentPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + DocumentPeer::NUM_HYDRATE_COLUMNS;

        FeatureCategoryPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + FeatureCategoryPeer::NUM_HYDRATE_COLUMNS;

        ImagePeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + ImagePeer::NUM_HYDRATE_COLUMNS;

        ProductCategoryPeer::addSelectColumns($criteria);
        $startcol8 = $startcol7 + ProductCategoryPeer::NUM_HYDRATE_COLUMNS;

        RewritingPeer::addSelectColumns($criteria);
        $startcol9 = $startcol8 + RewritingPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(CategoryPeer::ID, AttributeCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ContentAssocPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, DocumentPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, FeatureCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ImagePeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ProductCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, RewritingPeer::CATEGORY_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CategoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = CategoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CategoryPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined AttributeCategory rows

                $key2 = AttributeCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AttributeCategoryPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AttributeCategoryPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AttributeCategoryPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Category) to the collection in $obj2 (AttributeCategory)
                $obj1->setAttributeCategory($obj2);

            } // if joined row is not null

                // Add objects for joined ContentAssoc rows

                $key3 = ContentAssocPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = ContentAssocPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = ContentAssocPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    ContentAssocPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Category) to the collection in $obj3 (ContentAssoc)
                $obj1->setContentAssoc($obj3);

            } // if joined row is not null

                // Add objects for joined Document rows

                $key4 = DocumentPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = DocumentPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = DocumentPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    DocumentPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Category) to the collection in $obj4 (Document)
                $obj1->setDocument($obj4);

            } // if joined row is not null

                // Add objects for joined FeatureCategory rows

                $key5 = FeatureCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = FeatureCategoryPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = FeatureCategoryPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    FeatureCategoryPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Category) to the collection in $obj5 (FeatureCategory)
                $obj1->setFeatureCategory($obj5);

            } // if joined row is not null

                // Add objects for joined Image rows

                $key6 = ImagePeer::getPrimaryKeyHashFromRow($row, $startcol6);
                if ($key6 !== null) {
                    $obj6 = ImagePeer::getInstanceFromPool($key6);
                    if (!$obj6) {

                        $cls = ImagePeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    ImagePeer::addInstanceToPool($obj6, $key6);
                } // if $obj6 already loaded

                // Add the $obj1 (Category) to the collection in $obj6 (Image)
                $obj1->setImage($obj6);

            } // if joined row is not null

                // Add objects for joined ProductCategory rows

                $key7 = ProductCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol7);
                if ($key7 !== null) {
                    $obj7 = ProductCategoryPeer::getInstanceFromPool($key7);
                    if (!$obj7) {

                        $cls = ProductCategoryPeer::getOMClass();

                    $obj7 = new $cls();
                    $obj7->hydrate($row, $startcol7);
                    ProductCategoryPeer::addInstanceToPool($obj7, $key7);
                } // if $obj7 already loaded

                // Add the $obj1 (Category) to the collection in $obj7 (ProductCategory)
                $obj1->setProductCategory($obj7);

            } // if joined row is not null

                // Add objects for joined Rewriting rows

                $key8 = RewritingPeer::getPrimaryKeyHashFromRow($row, $startcol8);
                if ($key8 !== null) {
                    $obj8 = RewritingPeer::getInstanceFromPool($key8);
                    if (!$obj8) {

                        $cls = RewritingPeer::getOMClass();

                    $obj8 = new $cls();
                    $obj8->hydrate($row, $startcol8);
                    RewritingPeer::addInstanceToPool($obj8, $key8);
                } // if $obj8 already loaded

                // Add the $obj1 (Category) to the collection in $obj8 (Rewriting)
                $obj1->setRewriting($obj8);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Category objects pre-filled with all related objects except ContentAssoc.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Category objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptContentAssoc(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CategoryPeer::DATABASE_NAME);
        }

        CategoryPeer::addSelectColumns($criteria);
        $startcol2 = CategoryPeer::NUM_HYDRATE_COLUMNS;

        AttributeCategoryPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AttributeCategoryPeer::NUM_HYDRATE_COLUMNS;

        CategoryDescPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + CategoryDescPeer::NUM_HYDRATE_COLUMNS;

        DocumentPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + DocumentPeer::NUM_HYDRATE_COLUMNS;

        FeatureCategoryPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + FeatureCategoryPeer::NUM_HYDRATE_COLUMNS;

        ImagePeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + ImagePeer::NUM_HYDRATE_COLUMNS;

        ProductCategoryPeer::addSelectColumns($criteria);
        $startcol8 = $startcol7 + ProductCategoryPeer::NUM_HYDRATE_COLUMNS;

        RewritingPeer::addSelectColumns($criteria);
        $startcol9 = $startcol8 + RewritingPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(CategoryPeer::ID, AttributeCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, CategoryDescPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, DocumentPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, FeatureCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ImagePeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ProductCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, RewritingPeer::CATEGORY_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CategoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = CategoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CategoryPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined AttributeCategory rows

                $key2 = AttributeCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AttributeCategoryPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AttributeCategoryPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AttributeCategoryPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Category) to the collection in $obj2 (AttributeCategory)
                $obj1->setAttributeCategory($obj2);

            } // if joined row is not null

                // Add objects for joined CategoryDesc rows

                $key3 = CategoryDescPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = CategoryDescPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = CategoryDescPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    CategoryDescPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Category) to the collection in $obj3 (CategoryDesc)
                $obj1->setCategoryDesc($obj3);

            } // if joined row is not null

                // Add objects for joined Document rows

                $key4 = DocumentPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = DocumentPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = DocumentPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    DocumentPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Category) to the collection in $obj4 (Document)
                $obj1->setDocument($obj4);

            } // if joined row is not null

                // Add objects for joined FeatureCategory rows

                $key5 = FeatureCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = FeatureCategoryPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = FeatureCategoryPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    FeatureCategoryPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Category) to the collection in $obj5 (FeatureCategory)
                $obj1->setFeatureCategory($obj5);

            } // if joined row is not null

                // Add objects for joined Image rows

                $key6 = ImagePeer::getPrimaryKeyHashFromRow($row, $startcol6);
                if ($key6 !== null) {
                    $obj6 = ImagePeer::getInstanceFromPool($key6);
                    if (!$obj6) {

                        $cls = ImagePeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    ImagePeer::addInstanceToPool($obj6, $key6);
                } // if $obj6 already loaded

                // Add the $obj1 (Category) to the collection in $obj6 (Image)
                $obj1->setImage($obj6);

            } // if joined row is not null

                // Add objects for joined ProductCategory rows

                $key7 = ProductCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol7);
                if ($key7 !== null) {
                    $obj7 = ProductCategoryPeer::getInstanceFromPool($key7);
                    if (!$obj7) {

                        $cls = ProductCategoryPeer::getOMClass();

                    $obj7 = new $cls();
                    $obj7->hydrate($row, $startcol7);
                    ProductCategoryPeer::addInstanceToPool($obj7, $key7);
                } // if $obj7 already loaded

                // Add the $obj1 (Category) to the collection in $obj7 (ProductCategory)
                $obj1->setProductCategory($obj7);

            } // if joined row is not null

                // Add objects for joined Rewriting rows

                $key8 = RewritingPeer::getPrimaryKeyHashFromRow($row, $startcol8);
                if ($key8 !== null) {
                    $obj8 = RewritingPeer::getInstanceFromPool($key8);
                    if (!$obj8) {

                        $cls = RewritingPeer::getOMClass();

                    $obj8 = new $cls();
                    $obj8->hydrate($row, $startcol8);
                    RewritingPeer::addInstanceToPool($obj8, $key8);
                } // if $obj8 already loaded

                // Add the $obj1 (Category) to the collection in $obj8 (Rewriting)
                $obj1->setRewriting($obj8);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Category objects pre-filled with all related objects except Document.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Category objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptDocument(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CategoryPeer::DATABASE_NAME);
        }

        CategoryPeer::addSelectColumns($criteria);
        $startcol2 = CategoryPeer::NUM_HYDRATE_COLUMNS;

        AttributeCategoryPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AttributeCategoryPeer::NUM_HYDRATE_COLUMNS;

        CategoryDescPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + CategoryDescPeer::NUM_HYDRATE_COLUMNS;

        ContentAssocPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ContentAssocPeer::NUM_HYDRATE_COLUMNS;

        FeatureCategoryPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + FeatureCategoryPeer::NUM_HYDRATE_COLUMNS;

        ImagePeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + ImagePeer::NUM_HYDRATE_COLUMNS;

        ProductCategoryPeer::addSelectColumns($criteria);
        $startcol8 = $startcol7 + ProductCategoryPeer::NUM_HYDRATE_COLUMNS;

        RewritingPeer::addSelectColumns($criteria);
        $startcol9 = $startcol8 + RewritingPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(CategoryPeer::ID, AttributeCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, CategoryDescPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ContentAssocPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, FeatureCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ImagePeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ProductCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, RewritingPeer::CATEGORY_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CategoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = CategoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CategoryPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined AttributeCategory rows

                $key2 = AttributeCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AttributeCategoryPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AttributeCategoryPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AttributeCategoryPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Category) to the collection in $obj2 (AttributeCategory)
                $obj1->setAttributeCategory($obj2);

            } // if joined row is not null

                // Add objects for joined CategoryDesc rows

                $key3 = CategoryDescPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = CategoryDescPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = CategoryDescPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    CategoryDescPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Category) to the collection in $obj3 (CategoryDesc)
                $obj1->setCategoryDesc($obj3);

            } // if joined row is not null

                // Add objects for joined ContentAssoc rows

                $key4 = ContentAssocPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = ContentAssocPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = ContentAssocPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ContentAssocPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Category) to the collection in $obj4 (ContentAssoc)
                $obj1->setContentAssoc($obj4);

            } // if joined row is not null

                // Add objects for joined FeatureCategory rows

                $key5 = FeatureCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = FeatureCategoryPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = FeatureCategoryPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    FeatureCategoryPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Category) to the collection in $obj5 (FeatureCategory)
                $obj1->setFeatureCategory($obj5);

            } // if joined row is not null

                // Add objects for joined Image rows

                $key6 = ImagePeer::getPrimaryKeyHashFromRow($row, $startcol6);
                if ($key6 !== null) {
                    $obj6 = ImagePeer::getInstanceFromPool($key6);
                    if (!$obj6) {

                        $cls = ImagePeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    ImagePeer::addInstanceToPool($obj6, $key6);
                } // if $obj6 already loaded

                // Add the $obj1 (Category) to the collection in $obj6 (Image)
                $obj1->setImage($obj6);

            } // if joined row is not null

                // Add objects for joined ProductCategory rows

                $key7 = ProductCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol7);
                if ($key7 !== null) {
                    $obj7 = ProductCategoryPeer::getInstanceFromPool($key7);
                    if (!$obj7) {

                        $cls = ProductCategoryPeer::getOMClass();

                    $obj7 = new $cls();
                    $obj7->hydrate($row, $startcol7);
                    ProductCategoryPeer::addInstanceToPool($obj7, $key7);
                } // if $obj7 already loaded

                // Add the $obj1 (Category) to the collection in $obj7 (ProductCategory)
                $obj1->setProductCategory($obj7);

            } // if joined row is not null

                // Add objects for joined Rewriting rows

                $key8 = RewritingPeer::getPrimaryKeyHashFromRow($row, $startcol8);
                if ($key8 !== null) {
                    $obj8 = RewritingPeer::getInstanceFromPool($key8);
                    if (!$obj8) {

                        $cls = RewritingPeer::getOMClass();

                    $obj8 = new $cls();
                    $obj8->hydrate($row, $startcol8);
                    RewritingPeer::addInstanceToPool($obj8, $key8);
                } // if $obj8 already loaded

                // Add the $obj1 (Category) to the collection in $obj8 (Rewriting)
                $obj1->setRewriting($obj8);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Category objects pre-filled with all related objects except FeatureCategory.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Category objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptFeatureCategory(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CategoryPeer::DATABASE_NAME);
        }

        CategoryPeer::addSelectColumns($criteria);
        $startcol2 = CategoryPeer::NUM_HYDRATE_COLUMNS;

        AttributeCategoryPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AttributeCategoryPeer::NUM_HYDRATE_COLUMNS;

        CategoryDescPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + CategoryDescPeer::NUM_HYDRATE_COLUMNS;

        ContentAssocPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ContentAssocPeer::NUM_HYDRATE_COLUMNS;

        DocumentPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + DocumentPeer::NUM_HYDRATE_COLUMNS;

        ImagePeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + ImagePeer::NUM_HYDRATE_COLUMNS;

        ProductCategoryPeer::addSelectColumns($criteria);
        $startcol8 = $startcol7 + ProductCategoryPeer::NUM_HYDRATE_COLUMNS;

        RewritingPeer::addSelectColumns($criteria);
        $startcol9 = $startcol8 + RewritingPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(CategoryPeer::ID, AttributeCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, CategoryDescPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ContentAssocPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, DocumentPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ImagePeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ProductCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, RewritingPeer::CATEGORY_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CategoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = CategoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CategoryPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined AttributeCategory rows

                $key2 = AttributeCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AttributeCategoryPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AttributeCategoryPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AttributeCategoryPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Category) to the collection in $obj2 (AttributeCategory)
                $obj1->setAttributeCategory($obj2);

            } // if joined row is not null

                // Add objects for joined CategoryDesc rows

                $key3 = CategoryDescPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = CategoryDescPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = CategoryDescPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    CategoryDescPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Category) to the collection in $obj3 (CategoryDesc)
                $obj1->setCategoryDesc($obj3);

            } // if joined row is not null

                // Add objects for joined ContentAssoc rows

                $key4 = ContentAssocPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = ContentAssocPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = ContentAssocPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ContentAssocPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Category) to the collection in $obj4 (ContentAssoc)
                $obj1->setContentAssoc($obj4);

            } // if joined row is not null

                // Add objects for joined Document rows

                $key5 = DocumentPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = DocumentPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = DocumentPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    DocumentPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Category) to the collection in $obj5 (Document)
                $obj1->setDocument($obj5);

            } // if joined row is not null

                // Add objects for joined Image rows

                $key6 = ImagePeer::getPrimaryKeyHashFromRow($row, $startcol6);
                if ($key6 !== null) {
                    $obj6 = ImagePeer::getInstanceFromPool($key6);
                    if (!$obj6) {

                        $cls = ImagePeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    ImagePeer::addInstanceToPool($obj6, $key6);
                } // if $obj6 already loaded

                // Add the $obj1 (Category) to the collection in $obj6 (Image)
                $obj1->setImage($obj6);

            } // if joined row is not null

                // Add objects for joined ProductCategory rows

                $key7 = ProductCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol7);
                if ($key7 !== null) {
                    $obj7 = ProductCategoryPeer::getInstanceFromPool($key7);
                    if (!$obj7) {

                        $cls = ProductCategoryPeer::getOMClass();

                    $obj7 = new $cls();
                    $obj7->hydrate($row, $startcol7);
                    ProductCategoryPeer::addInstanceToPool($obj7, $key7);
                } // if $obj7 already loaded

                // Add the $obj1 (Category) to the collection in $obj7 (ProductCategory)
                $obj1->setProductCategory($obj7);

            } // if joined row is not null

                // Add objects for joined Rewriting rows

                $key8 = RewritingPeer::getPrimaryKeyHashFromRow($row, $startcol8);
                if ($key8 !== null) {
                    $obj8 = RewritingPeer::getInstanceFromPool($key8);
                    if (!$obj8) {

                        $cls = RewritingPeer::getOMClass();

                    $obj8 = new $cls();
                    $obj8->hydrate($row, $startcol8);
                    RewritingPeer::addInstanceToPool($obj8, $key8);
                } // if $obj8 already loaded

                // Add the $obj1 (Category) to the collection in $obj8 (Rewriting)
                $obj1->setRewriting($obj8);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Category objects pre-filled with all related objects except Image.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Category objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptImage(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CategoryPeer::DATABASE_NAME);
        }

        CategoryPeer::addSelectColumns($criteria);
        $startcol2 = CategoryPeer::NUM_HYDRATE_COLUMNS;

        AttributeCategoryPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AttributeCategoryPeer::NUM_HYDRATE_COLUMNS;

        CategoryDescPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + CategoryDescPeer::NUM_HYDRATE_COLUMNS;

        ContentAssocPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ContentAssocPeer::NUM_HYDRATE_COLUMNS;

        DocumentPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + DocumentPeer::NUM_HYDRATE_COLUMNS;

        FeatureCategoryPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + FeatureCategoryPeer::NUM_HYDRATE_COLUMNS;

        ProductCategoryPeer::addSelectColumns($criteria);
        $startcol8 = $startcol7 + ProductCategoryPeer::NUM_HYDRATE_COLUMNS;

        RewritingPeer::addSelectColumns($criteria);
        $startcol9 = $startcol8 + RewritingPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(CategoryPeer::ID, AttributeCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, CategoryDescPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ContentAssocPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, DocumentPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, FeatureCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ProductCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, RewritingPeer::CATEGORY_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CategoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = CategoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CategoryPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined AttributeCategory rows

                $key2 = AttributeCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AttributeCategoryPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AttributeCategoryPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AttributeCategoryPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Category) to the collection in $obj2 (AttributeCategory)
                $obj1->setAttributeCategory($obj2);

            } // if joined row is not null

                // Add objects for joined CategoryDesc rows

                $key3 = CategoryDescPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = CategoryDescPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = CategoryDescPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    CategoryDescPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Category) to the collection in $obj3 (CategoryDesc)
                $obj1->setCategoryDesc($obj3);

            } // if joined row is not null

                // Add objects for joined ContentAssoc rows

                $key4 = ContentAssocPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = ContentAssocPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = ContentAssocPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ContentAssocPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Category) to the collection in $obj4 (ContentAssoc)
                $obj1->setContentAssoc($obj4);

            } // if joined row is not null

                // Add objects for joined Document rows

                $key5 = DocumentPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = DocumentPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = DocumentPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    DocumentPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Category) to the collection in $obj5 (Document)
                $obj1->setDocument($obj5);

            } // if joined row is not null

                // Add objects for joined FeatureCategory rows

                $key6 = FeatureCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol6);
                if ($key6 !== null) {
                    $obj6 = FeatureCategoryPeer::getInstanceFromPool($key6);
                    if (!$obj6) {

                        $cls = FeatureCategoryPeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    FeatureCategoryPeer::addInstanceToPool($obj6, $key6);
                } // if $obj6 already loaded

                // Add the $obj1 (Category) to the collection in $obj6 (FeatureCategory)
                $obj1->setFeatureCategory($obj6);

            } // if joined row is not null

                // Add objects for joined ProductCategory rows

                $key7 = ProductCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol7);
                if ($key7 !== null) {
                    $obj7 = ProductCategoryPeer::getInstanceFromPool($key7);
                    if (!$obj7) {

                        $cls = ProductCategoryPeer::getOMClass();

                    $obj7 = new $cls();
                    $obj7->hydrate($row, $startcol7);
                    ProductCategoryPeer::addInstanceToPool($obj7, $key7);
                } // if $obj7 already loaded

                // Add the $obj1 (Category) to the collection in $obj7 (ProductCategory)
                $obj1->setProductCategory($obj7);

            } // if joined row is not null

                // Add objects for joined Rewriting rows

                $key8 = RewritingPeer::getPrimaryKeyHashFromRow($row, $startcol8);
                if ($key8 !== null) {
                    $obj8 = RewritingPeer::getInstanceFromPool($key8);
                    if (!$obj8) {

                        $cls = RewritingPeer::getOMClass();

                    $obj8 = new $cls();
                    $obj8->hydrate($row, $startcol8);
                    RewritingPeer::addInstanceToPool($obj8, $key8);
                } // if $obj8 already loaded

                // Add the $obj1 (Category) to the collection in $obj8 (Rewriting)
                $obj1->setRewriting($obj8);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Category objects pre-filled with all related objects except ProductCategory.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Category objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptProductCategory(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CategoryPeer::DATABASE_NAME);
        }

        CategoryPeer::addSelectColumns($criteria);
        $startcol2 = CategoryPeer::NUM_HYDRATE_COLUMNS;

        AttributeCategoryPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AttributeCategoryPeer::NUM_HYDRATE_COLUMNS;

        CategoryDescPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + CategoryDescPeer::NUM_HYDRATE_COLUMNS;

        ContentAssocPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ContentAssocPeer::NUM_HYDRATE_COLUMNS;

        DocumentPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + DocumentPeer::NUM_HYDRATE_COLUMNS;

        FeatureCategoryPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + FeatureCategoryPeer::NUM_HYDRATE_COLUMNS;

        ImagePeer::addSelectColumns($criteria);
        $startcol8 = $startcol7 + ImagePeer::NUM_HYDRATE_COLUMNS;

        RewritingPeer::addSelectColumns($criteria);
        $startcol9 = $startcol8 + RewritingPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(CategoryPeer::ID, AttributeCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, CategoryDescPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ContentAssocPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, DocumentPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, FeatureCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ImagePeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, RewritingPeer::CATEGORY_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CategoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = CategoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CategoryPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined AttributeCategory rows

                $key2 = AttributeCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AttributeCategoryPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AttributeCategoryPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AttributeCategoryPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Category) to the collection in $obj2 (AttributeCategory)
                $obj1->setAttributeCategory($obj2);

            } // if joined row is not null

                // Add objects for joined CategoryDesc rows

                $key3 = CategoryDescPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = CategoryDescPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = CategoryDescPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    CategoryDescPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Category) to the collection in $obj3 (CategoryDesc)
                $obj1->setCategoryDesc($obj3);

            } // if joined row is not null

                // Add objects for joined ContentAssoc rows

                $key4 = ContentAssocPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = ContentAssocPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = ContentAssocPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ContentAssocPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Category) to the collection in $obj4 (ContentAssoc)
                $obj1->setContentAssoc($obj4);

            } // if joined row is not null

                // Add objects for joined Document rows

                $key5 = DocumentPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = DocumentPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = DocumentPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    DocumentPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Category) to the collection in $obj5 (Document)
                $obj1->setDocument($obj5);

            } // if joined row is not null

                // Add objects for joined FeatureCategory rows

                $key6 = FeatureCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol6);
                if ($key6 !== null) {
                    $obj6 = FeatureCategoryPeer::getInstanceFromPool($key6);
                    if (!$obj6) {

                        $cls = FeatureCategoryPeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    FeatureCategoryPeer::addInstanceToPool($obj6, $key6);
                } // if $obj6 already loaded

                // Add the $obj1 (Category) to the collection in $obj6 (FeatureCategory)
                $obj1->setFeatureCategory($obj6);

            } // if joined row is not null

                // Add objects for joined Image rows

                $key7 = ImagePeer::getPrimaryKeyHashFromRow($row, $startcol7);
                if ($key7 !== null) {
                    $obj7 = ImagePeer::getInstanceFromPool($key7);
                    if (!$obj7) {

                        $cls = ImagePeer::getOMClass();

                    $obj7 = new $cls();
                    $obj7->hydrate($row, $startcol7);
                    ImagePeer::addInstanceToPool($obj7, $key7);
                } // if $obj7 already loaded

                // Add the $obj1 (Category) to the collection in $obj7 (Image)
                $obj1->setImage($obj7);

            } // if joined row is not null

                // Add objects for joined Rewriting rows

                $key8 = RewritingPeer::getPrimaryKeyHashFromRow($row, $startcol8);
                if ($key8 !== null) {
                    $obj8 = RewritingPeer::getInstanceFromPool($key8);
                    if (!$obj8) {

                        $cls = RewritingPeer::getOMClass();

                    $obj8 = new $cls();
                    $obj8->hydrate($row, $startcol8);
                    RewritingPeer::addInstanceToPool($obj8, $key8);
                } // if $obj8 already loaded

                // Add the $obj1 (Category) to the collection in $obj8 (Rewriting)
                $obj1->setRewriting($obj8);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Category objects pre-filled with all related objects except Rewriting.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Category objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptRewriting(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CategoryPeer::DATABASE_NAME);
        }

        CategoryPeer::addSelectColumns($criteria);
        $startcol2 = CategoryPeer::NUM_HYDRATE_COLUMNS;

        AttributeCategoryPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AttributeCategoryPeer::NUM_HYDRATE_COLUMNS;

        CategoryDescPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + CategoryDescPeer::NUM_HYDRATE_COLUMNS;

        ContentAssocPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ContentAssocPeer::NUM_HYDRATE_COLUMNS;

        DocumentPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + DocumentPeer::NUM_HYDRATE_COLUMNS;

        FeatureCategoryPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + FeatureCategoryPeer::NUM_HYDRATE_COLUMNS;

        ImagePeer::addSelectColumns($criteria);
        $startcol8 = $startcol7 + ImagePeer::NUM_HYDRATE_COLUMNS;

        ProductCategoryPeer::addSelectColumns($criteria);
        $startcol9 = $startcol8 + ProductCategoryPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(CategoryPeer::ID, AttributeCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, CategoryDescPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ContentAssocPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, DocumentPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, FeatureCategoryPeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ImagePeer::CATEGORY_ID, $join_behavior);

        $criteria->addJoin(CategoryPeer::ID, ProductCategoryPeer::CATEGORY_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CategoryPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CategoryPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = CategoryPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CategoryPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined AttributeCategory rows

                $key2 = AttributeCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AttributeCategoryPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AttributeCategoryPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AttributeCategoryPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Category) to the collection in $obj2 (AttributeCategory)
                $obj1->setAttributeCategory($obj2);

            } // if joined row is not null

                // Add objects for joined CategoryDesc rows

                $key3 = CategoryDescPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = CategoryDescPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = CategoryDescPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    CategoryDescPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Category) to the collection in $obj3 (CategoryDesc)
                $obj1->setCategoryDesc($obj3);

            } // if joined row is not null

                // Add objects for joined ContentAssoc rows

                $key4 = ContentAssocPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = ContentAssocPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = ContentAssocPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ContentAssocPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Category) to the collection in $obj4 (ContentAssoc)
                $obj1->setContentAssoc($obj4);

            } // if joined row is not null

                // Add objects for joined Document rows

                $key5 = DocumentPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = DocumentPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = DocumentPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    DocumentPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Category) to the collection in $obj5 (Document)
                $obj1->setDocument($obj5);

            } // if joined row is not null

                // Add objects for joined FeatureCategory rows

                $key6 = FeatureCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol6);
                if ($key6 !== null) {
                    $obj6 = FeatureCategoryPeer::getInstanceFromPool($key6);
                    if (!$obj6) {

                        $cls = FeatureCategoryPeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    FeatureCategoryPeer::addInstanceToPool($obj6, $key6);
                } // if $obj6 already loaded

                // Add the $obj1 (Category) to the collection in $obj6 (FeatureCategory)
                $obj1->setFeatureCategory($obj6);

            } // if joined row is not null

                // Add objects for joined Image rows

                $key7 = ImagePeer::getPrimaryKeyHashFromRow($row, $startcol7);
                if ($key7 !== null) {
                    $obj7 = ImagePeer::getInstanceFromPool($key7);
                    if (!$obj7) {

                        $cls = ImagePeer::getOMClass();

                    $obj7 = new $cls();
                    $obj7->hydrate($row, $startcol7);
                    ImagePeer::addInstanceToPool($obj7, $key7);
                } // if $obj7 already loaded

                // Add the $obj1 (Category) to the collection in $obj7 (Image)
                $obj1->setImage($obj7);

            } // if joined row is not null

                // Add objects for joined ProductCategory rows

                $key8 = ProductCategoryPeer::getPrimaryKeyHashFromRow($row, $startcol8);
                if ($key8 !== null) {
                    $obj8 = ProductCategoryPeer::getInstanceFromPool($key8);
                    if (!$obj8) {

                        $cls = ProductCategoryPeer::getOMClass();

                    $obj8 = new $cls();
                    $obj8->hydrate($row, $startcol8);
                    ProductCategoryPeer::addInstanceToPool($obj8, $key8);
                } // if $obj8 already loaded

                // Add the $obj1 (Category) to the collection in $obj8 (ProductCategory)
                $obj1->setProductCategory($obj8);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }

    /**
     * Returns the TableMap related to this peer.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getDatabaseMap(CategoryPeer::DATABASE_NAME)->getTable(CategoryPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseCategoryPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseCategoryPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new CategoryTableMap());
      }
    }

    /**
     * The class that the Peer will make instances of.
     *
     *
     * @return string ClassName
     */
    public static function getOMClass()
    {
        return CategoryPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Category or Criteria object.
     *
     * @param      mixed $values Criteria or Category object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Category object
        }

        if ($criteria->containsKey(CategoryPeer::ID) && $criteria->keyContainsValue(CategoryPeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CategoryPeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

    /**
     * Performs an UPDATE on the database, given a Category or Criteria object.
     *
     * @param      mixed $values Criteria or Category object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(CategoryPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(CategoryPeer::ID);
            $value = $criteria->remove(CategoryPeer::ID);
            if ($value) {
                $selectCriteria->add(CategoryPeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(CategoryPeer::TABLE_NAME);
            }

        } else { // $values is Category object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the category table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(CategoryPeer::TABLE_NAME, $con, CategoryPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CategoryPeer::clearInstancePool();
            CategoryPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Category or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or Category object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param      PropelPDO $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *				if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, PropelPDO $con = null)
     {
        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            CategoryPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Category) { // it's a model object
            // invalidate the cache for this single object
            CategoryPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CategoryPeer::DATABASE_NAME);
            $criteria->add(CategoryPeer::ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                CategoryPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(CategoryPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            CategoryPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given Category object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param      Category $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(CategoryPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(CategoryPeer::TABLE_NAME);

            if (! is_array($cols)) {
                $cols = array($cols);
            }

            foreach ($cols as $colName) {
                if ($tableMap->hasColumn($colName)) {
                    $get = 'get' . $tableMap->getColumn($colName)->getPhpName();
                    $columns[$colName] = $obj->$get();
                }
            }
        } else {

        }

        return BasePeer::doValidate(CategoryPeer::DATABASE_NAME, CategoryPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param      int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Category
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = CategoryPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(CategoryPeer::DATABASE_NAME);
        $criteria->add(CategoryPeer::ID, $pk);

        $v = CategoryPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Category[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CategoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(CategoryPeer::DATABASE_NAME);
            $criteria->add(CategoryPeer::ID, $pks, Criteria::IN);
            $objs = CategoryPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseCategoryPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseCategoryPeer::buildTableMap();

