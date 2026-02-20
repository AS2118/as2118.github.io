<?php
// admin.php - API导航网后台管理（带排序）
session_start();

// 密码
$password = 'ansheng2118';

// 登录处理
if (isset($_POST['login'])) {
    if ($_POST['password'] == $password) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        $error = '密码错误！';
    }
}

// 退出
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

// 检查登录
$is_logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// 读取文件
function getHtmlContent() {
    return file_get_contents('index.htm');
}

// 保存文件
function saveHtmlContent($content) {
    return file_put_contents('index.htm', $content);
}

// QQ号转头像
function qqToAvatar($qq) {
    return 'https://q.qlogo.cn/headimg_dl?dst_uin=' . trim($qq) . '&spec=640';
}

// 从API名称提取数字
function getApiNumber($name) {
    preg_match('/(\d+)$/', $name, $matches);
    return isset($matches[1]) ? intval($matches[1]) : 0;
}

// 生成API代码
function generateApiHtml($name, $url, $qq) {
    $avatar = qqToAvatar($qq);
    return '                    <li>
                        <a href="' . $url . '" tppabs="' . $url . '">
                            <img src="' . $avatar . '" tppabs="' . $avatar . '" alt="" />
                            <span>' . $name . '</span>
                        </a>
                    </li>
                    <!--img src=http://c559899f466b80ea2607802b09f5b96a6964915-->';
}

// 获取"接口较多"分类下的所有API
function getApisFromCategory($html) {
    $apis = [];
    
    // 找到"接口较多"后面的ul内容
    $pos = strpos($html, '接口较多');
    if ($pos === false) return $apis;
    
    $ul_pos = strpos($html, '<ul', $pos);
    if ($ul_pos === false) return $apis;
    
    $ul_open = strpos($html, '>', $ul_pos) + 1;
    $ul_close = strpos($html, '</ul>', $ul_open);
    if ($ul_close === false) return $apis;
    
    $ul_content = substr($html, $ul_open, $ul_close - $ul_open);
    
    // 提取所有li
    preg_match_all('/<li>.*?<\/li>\s*<!--img[^>]+-->/is', $ul_content, $matches);
    
    foreach ($matches[0] as $li) {
        // 提取名称
        if (preg_match('/<span>([^<]+)<\/span>/', $li, $name_match)) {
            $name = $name_match[1];
            $number = getApiNumber($name);
            $apis[] = [
                'html' => $li,
                'name' => $name,
                'number' => $number
            ];
        }
    }
    
    return $apis;
}

// 按数字排序（从大到小）
function sortApis($a, $b) {
    return $b['number'] - $a['number'];
}

// 处理添加
if ($is_logged_in && isset($_POST['add'])) {
    $name = $_POST['name'];
    $url = $_POST['url'];
    $qq = $_POST['qq'];
    
    // 生成新API
    $new_api = generateApiHtml($name, $url, $qq);
    $new_number = getApiNumber($name);
    
    // 读取文件
    $html = getHtmlContent();
    
    // 找到"接口较多"后面的ul
    $pos = strpos($html, '接口较多');
    if ($pos !== false) {
        $ul_pos = strpos($html, '<ul', $pos);
        if ($ul_pos !== false) {
            $ul_open = strpos($html, '>', $ul_pos) + 1;
            $ul_close = strpos($html, '</ul>', $ul_open);
            
            if ($ul_close !== false) {
                // 获取现有API
                $apis = getApisFromCategory($html);
                
                // 添加新API
                $apis[] = [
                    'html' => $new_api,
                    'name' => $name,
                    'number' => $new_number
                ];
                
                // 排序
                usort($apis, 'sortApis');
                
                // 重新生成ul内容
                $new_ul_content = '';
                foreach ($apis as $api) {
                    $new_ul_content .= $api['html'] . "\n";
                }
                
                // 替换ul内容
                $new_html = substr($html, 0, $ul_open) . "\n" . $new_ul_content . substr($html, $ul_close);
                
                if (saveHtmlContent($new_html)) {
                    $message = '✅ 添加成功！已按数量排序（从大到小）';
                } else {
                    $error = '❌ 保存失败！';
                }
            } else {
                $error = '找不到</ul>标签';
            }
        } else {
            $error = '找不到<ul>标签';
        }
    } else {
        $error = '找不到"接口较多"分类';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API后台</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 15px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        .container { max-width: 500px; margin: 0 auto; }
        .box {
            background: white;
            border-radius: 20px;
            padding: 25px 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            color: #333;
            font-size: 24px;
            margin-bottom: 25px;
        }
        .form-group { margin-bottom: 20px; }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }
        input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 16px;
            background: #f8f9fa;
        }
        input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
        }
        button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
        }
        button:active { transform: scale(0.98); }
        .error {
            background: #fee;
            color: #c33;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
        }
        .success {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
        }
        .logout {
            text-align: right;
            margin-bottom: 15px;
        }
        .logout a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            background: rgba(255,255,255,0.2);
            border-radius: 20px;
            display: inline-block;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            color: white;
        }
        .site-link {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            background: rgba(255,255,255,0.2);
            border-radius: 20px;
        }
        .info {
            background: #e3f2fd;
            color: #0d47a1;
            padding: 12px;
            border-radius: 10px;
            margin-top: 15px;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!$is_logged_in): ?>
            <!-- 登录 -->
            <div class="box">
                <h2>👤 登录</h2>
                <?php if (isset($error)): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="form-group">
                        <label>密码</label>
                        <input type="password" name="password" required placeholder="admin123">
                    </div>
                    <button type="submit" name="login">登录</button>
                </form>
            </div>
        <?php else: ?>
            <!-- 管理 -->
            <div class="header">
                <span>API导航网</span>
                <a href="index.htm" class="site-link" target="_blank">查看</a>
            </div>
            
            <div class="box">
                <h2>➕ 添加API</h2>
                <?php if (isset($message)): ?>
                    <div class="success"><?php echo $message; ?></div>
                <?php endif; ?>
                <?php if (isset($error)): ?>
                    <div class="error"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="post">
                    <div class="form-group">
                        <label>API名称</label>
                        <input type="text" name="name" required placeholder="例如：安生API30">
                        <small style="color: #999; display: block; margin-top: 5px;">数字越大排序越靠前</small>
                    </div>
                    <div class="form-group">
                        <label>网站链接</label>
                        <input type="url" name="url" required placeholder="https://example.com/">
                    </div>
                    <div class="form-group">
                        <label>QQ号</label>
                        <input type="text" name="qq" required placeholder="583669165">
                    </div>
                    <button type="submit" name="add">添加</button>
                </form>
                
                <div class="info">
                    📌 添加后自动按数字从大到小排序
                </div>
            </div>
            
            <div class="logout">
                <a href="?logout=1">退出</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
