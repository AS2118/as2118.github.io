<?php
// cj.php - 从index.htm采集API站点信息（简化版）
header('Content-Type: text/html; charset=utf-8');

// 采集函数
function crawlApiSites() {
    // 读取index.htm文件
    $html_file = 'index.htm';
    
    if (!file_exists($html_file)) {
        return ['error' => 'index.htm 文件不存在'];
    }
    
    $html = file_get_contents($html_file);
    if (empty($html)) {
        return ['error' => '无法读取index.htm文件内容'];
    }
    
    $api_sites = [];
    
    // 使用正则表达式匹配API站点
    $pattern = '/<li>\s*<a href="([^"]+)"[^>]*>\s*<img[^>]*>\s*<span>([^<]+)<\/span>\s*<\/a>\s*<\/li>/is';
    
    preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);
    
    foreach ($matches as $match) {
        $url = $match[1];
        $name = trim($match[2]);
        
        // 提取API数量（从名称中提取数字）
        preg_match('/(\d+)$/', $name, $count_match);
        $count = isset($count_match[1]) ? intval($count_match[1]) : 0;
        
        // 清理名称中的数字
        $clean_name = preg_replace('/\d+$/', '', $name);
        $clean_name = trim($clean_name);
        
        // 只保留需要的字段
        $api_sites[] = [
            'name' => $name,
            'url' => $url,
            'count' => $count
        ];
    }
    
    return $api_sites;
}

// 执行采集
$result = crawlApiSites();

// 如果是搜索请求
if (isset($_GET['q'])) {
    header('Content-Type: text/plain; charset=utf-8');
    $keyword = trim($_GET['q']);
    
    if (empty($keyword)) {
        echo "API导航网 - 搜索接口\n";
        echo "==================\n";
        echo "使用方法：http://as.nm.cn/cj.php?q=关键词\n";
        echo "示例：http://as.nm.cn/cj.php?q=云\n";
        echo "\n";
        echo "当前共有 " . count($result) . " 个API站点\n";
        exit;
    }
    
    // 执行搜索
    $results = [];
    foreach ($result as $site) {
        if (stripos($site['name'], $keyword) !== false) {
            $results[] = $site;
        }
    }
    
    // 输出搜索结果
    if (empty($results)) {
        echo "未找到包含“{$keyword}”的API站点\n";
        echo "试试其他关键词吧！\n";
    } else {
        $count = count($results);
        echo "找到 {$count} 个包含“{$keyword}”的API站点：\n";
        echo "========\n";
        foreach ($results as $index => $site) {
            $number = $index + 1;
            echo "{$number}. {$site['name']}\n";
            echo "   链接：{$site['url']}\n";
            echo "   数量：{$site['count']}个接口\n";
            echo "";
        }
        echo "========\n";
        echo "安生API导航网";
    }
    exit;
}

// JSON格式输出
if (isset($_GET['format']) && $_GET['format'] == 'json') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API采集工具 - 简化版</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Microsoft YaHei', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        h1 span {
            color: #667eea;
        }
        .stats {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-around;
            text-align: center;
        }
        .stat-item {
            flex: 1;
        }
        .stat-number {
            font-size: 36px;
            font-weight: bold;
        }
        .stat-label {
            font-size: 14px;
            opacity: 0.9;
        }
        .search-box {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        .search-box input {
            flex: 1;
            padding: 12px;
            border: 2px solid #eee;
            border-radius: 5px;
            font-size: 16px;
        }
        .search-box input:focus {
            outline: none;
            border-color: #667eea;
        }
        .search-box button {
            padding: 12px 24px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .search-box button:hover {
            background: #5a67d8;
        }
        .api-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .api-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #eee;
        }
        .api-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .api-header {
            margin-bottom: 10px;
        }
        .api-header h3 {
            color: #333;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .api-count {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 12px;
        }
        .api-url {
            color: #666;
            font-size: 12px;
            margin: 10px 0;
            word-break: break-all;
        }
        .api-url a {
            color: #667eea;
            text-decoration: none;
        }
        .api-url a:hover {
            text-decoration: underline;
        }
        .error-box {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .info-box {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .info-box h3 {
            color: #2196F3;
            margin-bottom: 10px;
        }
        pre {
            background: #f4f4f4;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
            margin: 10px 0;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .btn {
            padding: 8px 16px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background: #218838;
        }
        .btn.json {
            background: #17a2b8;
        }
        .btn.json:hover {
            background: #138496;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>API采集工具 <span>as.nm.cn</span></h1>
        
        <?php if (isset($result['error'])): ?>
            <div class="error-box">
                <strong>错误：</strong> <?php echo htmlspecialchars($result['error']); ?>
                <p style="margin-top: 10px;">请确保 index.htm 文件存在于同一目录下</p>
            </div>
        <?php else: ?>
            <!-- 统计信息 -->
            <div class="stats">
                <div class="stat-item">
                    <div class="stat-number"><?php echo count($result); ?></div>
                    <div class="stat-label">API站点总数</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">
                        <?php 
                        $total_count = array_sum(array_column($result, 'count'));
                        echo $total_count;
                        ?>
                    </div>
                    <div class="stat-label">接口总数</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">
                        <?php 
                        $max_count = !empty($result) ? max(array_column($result, 'count')) : 0;
                        echo $max_count;
                        ?>
                    </div>
                    <div class="stat-label">最多接口</div>
                </div>
            </div>
            
            <!-- 使用说明 -->
            <div class="info-box">
                <h3>📢 搜索API接口使用说明</h3>
                <p><strong>接口地址：</strong> http://as.nm.cn/cj.php?q=关键词</p>
                <p><strong>返回格式示例：</strong></p>
                <pre>
找到 3 个包含“云”的API站点：
=======

1. 云智API188
   链接：https://yunzhiapi.cn/?page=list
   数量：188个接口

2. 桑帛云API118
   链接：https://api.lolimi.cn/
   数量：118个接口

=======
API导航网 - as.nm.cn
                </pre>
                <p style="margin-top: 10px;">
                    <a href="?format=json" class="btn json" target="_blank">查看JSON数据</a>
                </p>
            </div>
            
            <!-- 搜索框 -->
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="输入关键词搜索API站点...">
                <button onclick="searchAPIs()">搜索</button>
                <button onclick="clearSearch()" style="background: #6c757d;">清除</button>
            </div>
            
            <!-- API列表 -->
            <div class="api-grid" id="apiGrid">
                <?php foreach ($result as $api): ?>
                <div class="api-card" data-name="<?php echo htmlspecialchars($api['name']); ?>">
                    <div class="api-header">
                        <h3><?php echo htmlspecialchars($api['name']); ?></h3>
                        <span class="api-count"><?php echo $api['count']; ?>个接口</span>
                    </div>
                    <div class="api-url">
                        <a href="<?php echo htmlspecialchars($api['url']); ?>" target="_blank">
                            <?php echo htmlspecialchars($api['url']); ?>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="footer">
                采集时间：<?php echo date('Y-m-d H:i:s'); ?> | 共采集到 <?php echo count($result); ?> 个API站点<br>
                <small>网站：as.nm.cn | 采集文件：cj.php</small>
            </div>
        <?php endif; ?>
    </div>
    
    <script>
        function searchAPIs() {
            var input = document.getElementById('searchInput');
            var filter = input.value.toUpperCase();
            var cards = document.querySelectorAll('.api-card');
            
            for (var i = 0; i < cards.length; i++) {
                var name = cards[i].getAttribute('data-name').toUpperCase();
                if (name.indexOf(filter) > -1) {
                    cards[i].style.display = '';
                } else {
                    cards[i].style.display = 'none';
                }
            }
        }
        
        function clearSearch() {
            document.getElementById('searchInput').value = '';
            var cards = document.querySelectorAll('.api-card');
            for (var i = 0; i < cards.length; i++) {
                cards[i].style.display = '';
            }
        }
    </script>
</body>
</html>
