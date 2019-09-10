<?php
/**
 * Created by PhpStorm.
 * User: 61458
 * Date: 2019/6/22
 * Time: 12:33
 */

namespace libs;
class Db
{

    private $pdo = null;//pdo对象
    private static $db = null;//Db类对象
    private $table = '';
    private $where = '';
    private $order = '';
    private $filed = '*';
    private $limit = '';

    /*
     * 初始化构造函数，完成数据库的链接
     */
    private function __construct()
    {
        class_exists('PDO') ? '' : exit('PDO Class No Found');
        try {
            $this->pdo = new \PDO(DbConfig::getDsn(), DbConfig::getUser(), DbConfig::getPassword());
        } catch (PDOException $e) {
            echo "数据库链接失败~" . $e->getMessage();
            exit();
        } catch (Exception $e) {
            echo '数据库链接发生错误';
            exit();
        }
    }

    /*
     * 销毁Db对象也清除pdo对象
     */
    public function close()
    {
        $this->pdo = null;
    }

    /*
     * 防止克隆对象
     */
    public function __clone()
    {
        exit('禁止克隆数据库对象');
    }

    /*
     * 利用单例模式获取数据库Db类对象
     * @return Db类对象
     */
    public static function getInstance()
    {
        if (is_null(self::$db))
            self::$db = new self();
        return self::$db;
    }

    /*
     * 指定表名称
     * @param var $table 数据表名
     * @return obj 返回一个Db对象
     */
    public function table($table)
    {
        $this->filed = '';
        $this->limit = '';
        $this->order = '';
        $this->where = '';
        $this->table = $table;
        return $this;
    }

    /*
     * 指定查询数据段
     * @param var $filed 字段名
     * @return obj 返回一个Db对象
     */
    public function filed($filed)
    {
        $this->filed = $filed;
        return $this;
    }

    /*
     * 指定where条件
     * @param var $where 查询条件 数组或字符串
     * @return obj 返回一个Db对象
     */
    public function where($where)
    {
        $this->where = $where;
        return $this;
    }

    /*
     * 指定排序规则
     * @param 字段加排序规则 默认升序  DESC降序 ACS升序（默认）
     * @return obj 返回一个Db对象
     */
    public function order($order)
    {
        //判断是否执行order条件
        $this->order = $order;
        return $this;
    }

    /*
    * 限制查询数目
    * @param int 查询数目
    * @return obj 返回一个Db对象
    */
    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /*
     * 返回一条数据
     * @return 返回查询结果数据集以数组形式
     */
    public function item()
    {
        //防止用户调用item时调用limit条件
        if ($this->limit > 1) $this->limit = 1;
        $sql = $this->buildSql('select');
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return isset($result[0]) ? $result[0] : $result;

    }

    /*
    * 返回多条数据
    * @param 查询结果数量,默认返回查询全部
    * @return 返回查询结果数据集以数组形式
    */
    public function lists()
    {
        $sql = $this->buildSql('select');
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $result;

    }

    /*
     * 添加数据
     * @param array('字段名'=>'字段值’) 要插入的数组
     * @return int 返回受影响行数
     */
    public function insert($data)
    {
        $sql = $this->buildSql('insert', $data);exit($sql);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->rowCount();
        return $result;
    }

    /*
     * 更新数据
     * @param array('字段名'=>'字段值) 要更新的字段数组
     * @param int 返回受影响的行数
     */
    public function update($data)
    {
        $sql = $this->buildSql('update', $data);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->rowCount();
        return $result;
    }

    /*
     * 删除数据
     * @return int 返回受影响行数
     */
    public function delete()
    {
        $sql = $this->buildSql('delete');
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->rowCount();
        return $result;
    }

    /*
     * 分页函数
     * @param $page 当前页  $pageSize每页页数
     * @return array[][] 二维数组  var total总数 array $data 数据数组
     */
    public function pages($page, $pageSize = 10, $path)
    {
        //获取查询数据总数
        $total = $this->total();
        $this->limit = ($page - 1) * $pageSize . "," . $pageSize;
        $data = $this->lists();
        $pages = $this->subPages($page, $pageSize, $total, $path);
        return array('total' => $total, 'result' => $data, 'pages' => $pages);
    }

    /*
     * 构造分页html样式（BS风格）页面数
     * @param $curPage 当前页 $pageSize 页面数 $total 数据数量
     * @return $html 分页样式
     */
    private function subPages($curPage, $pageSize, $total, $path)
    {
        //处理多get参数问题
        $symbol = '?';
        $flag = strpos($path, $symbol);
        if ($flag !== false && $flag > 0) $symbol = '&';
        $html = '';
        //分页数,向上取整
        $pageCount = ceil($total / $pageSize);
        //当前页为首页则不显示上一页跟首页
        if ($curPage != 1) {
            $html = "<li><a href='{$path}{$symbol}page=1' >首页</a></li>";
            $prePage = $curPage - 1 < 1 ? 1 : $curPage - 1;
            $html .= "<li><a href='{$path}{$symbol}page={$prePage}' >上一页</a></li>";
        }
        //生成数字页
        $start = 1;
        $end = $pageCount;
        //当记录大于60条，才显示前6条
        if ($total > 60) {
            $start = $curPage > ($pageCount - 6) ? ($pageCount - 6) : $curPage;
            $start = $start - 2;
            $start = $start <= 0 ? 1 : $start;
            $end = ($curPage + 6) > $pageCount ? $pageCount : ($curPage + 6);
            $end = $end - 2;
            if ($curPage + 2 > $end) {
                $start = $start + 2;
                $end = $end + 2;
            }
        }
        //页数小于1，不显示分页
        if ($pageCount <= 1) {
            return;
        }


        for ($i = $start; $i <= $end;
             $i++) {
            $html .= $curPage == $i ? "<li class='active'><a>{$i}</li></a>" : "<li><a href='{$path}{$symbol}page={$i}'>{$i}</a></li>";
        }

        //当前页为尾页则不显示下一页跟尾页
        if ($curPage != $pageCount) {
            $nextPage = $curPage + 1 > $pageCount ? $pageCount : $curPage + 1;
            $html .= "<li><a href='{$path}{$symbol}page={$nextPage}' >下一页</a></li>";
            $html .= "<li><a href='{$path}{$symbol}page={$pageCount}'>尾页</a></li>";
        }
        //拼接html
        $html = "<nav aria-label='pagination' class='text-center'>
                    <ul class='pagination'>" . $html . "</ul></nav>";
        return $html;
    }

    //计算查询数据总数
    private function total()
    {
        $sql = $this->buildSql('count');
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $total = $stmt->fetchColumn(0);
        return $total;
    }

    /*
     * 构造sql语句
     * @return $var 返回一个构造成功的sql字符串
     */
    private function buildSql($type, $data = null)
    {
        $sql = '';
        //查询
        if ($type == 'select') {
            $where = $this->buildWhere();
            $order = empty($this->order) ? '' : "order by {$this->order}";
            $limit = empty($this->limit) ? '' : "limit {$this->limit}";
            $filed = empty($this->filed) ? '*' : $this->filed;
            $sql = "select {$filed} from {$this->table} {$where} {$order} {$limit}";
        }

        if ($type == 'count') {
            $where = $this->buildWhere();
            //防止分页查询筛选多个字段出错，规避错误
            $filed_list = explode(',', $this->filed);
            $filed = count($filed_list) > 0 ? '*' : $this->filed;
            $sql = "select count({$filed}) from {$this->table} {$where}";
        }

        //添加
        if ($type == 'insert') {
            $str = '';
            foreach ($data as $k => $v) {
                $filed[] = "`" . $k . "`";
                $val[] = is_string($v) ? "'" . $v . "'" : $v;
            }
            $str = " (" . implode(',', $filed) . ")" . " values (" . implode(',', $val) . ")";
            $sql .= "insert into {$this->table} {$str}";
        }

        //更新
        if ($type == 'update') {
            $set = 'set ';
            foreach ($data as $k => $v) {
                $v = is_string($v) ? "'" . $v . "'" : $v;
                $set .= "{$k} = {$v},";
            }
            $set = rtrim($set, ',');
            $where = $this->buildWhere();
            $sql = "update {$this->table} {$set} {$where}";
        }

        //删除
        if ($type == 'delete') {
            $where = $this->buildWhere();
            $sql = "delete from {$this->table} {$where}";
        }

        return $sql;
    }

    /*
     * 构造where条件
     * @param $flag 是否区分大小写查询，默认区分
     * @return 返回一个where条件
     */
    private function buildWhere()
    {
        $where = '';
        //判断where条件是数组或者字符串
        if (is_array($this->where)) {
            foreach ($this->where as $key => $value) {
                $value = is_string($value) ? "'" . $value . "'" : $value;
                $where .= "`{$key}`={$value} and ";
            }
        } else {
            //条件为字符串
            $where = $this->where;
        }
        //判断是否执行where条件

        $where = $where == '' ? '' : "where  {$where}";
        $where = rtrim($where, 'and ');

        return $where;
    }

}




