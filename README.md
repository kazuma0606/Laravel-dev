# Laravel Task Manager

シンプルで直感的なタスク管理システム。Laravel 12 + Docker + PostgreSQLで構築された、レスポンシブ対応のWebアプリケーションです。

## 🎯 概要

このプロジェクトは、個人やチームのタスク管理を効率化するためのWebアプリケーションです。Docker環境で簡単にセットアップでき、モダンなUIで快適にタスク管理ができます。

## ✨ 機能

### 📝 タスク管理
- ✅ **新規タスク作成** - タイトル、説明、優先度を設定してタスクを作成
- ✅ **タスク一覧表示** - 作成したタスクを時系列で表示
- ✅ **完了チェック** - チェックボックスでタスクの完了状態をリアルタイム更新
- ✅ **タスク削除** - 不要なタスクを削除

### 📊 統計・分析
- 📈 **進捗統計** - 総タスク数、完了数、未完了数を表示
- 📊 **完了率** - 視覚的な進捗バーで完了率を表示
- 🎯 **優先度管理** - High/Medium/Lowの3段階で優先度設定

### 🔍 フィルタリング
- 🗂️ **状態別表示** - All / Pending / Completedでタスクをフィルタリング
- 🏷️ **優先度表示** - カラーコードで優先度を視覚的に識別

### 🎨 UI/UX
- 📱 **レスポンシブデザイン** - デスクトップ/タブレット/モバイル対応
- 🎨 **モダンUI** - Tailwind CSSによる洗練されたデザイン
- ⚡ **高速レスポンス** - AJAXによるスムーズなタスク操作

## 🛠️ 技術スタック

### バックエンド
- **Laravel 12** - PHPフレームワーク
- **PostgreSQL 15** - メインデータベース
- **PHP 8.2** - サーバーサイド言語

### フロントエンド  
- **Blade Templates** - Laravel標準のテンプレートエンジン
- **Tailwind CSS** - ユーティリティファーストCSSフレームワーク
- **Alpine.js** - 軽量JavaScriptフレームワーク
- **Axios** - HTTP クライアント（AJAX通信用）

### インフラ
- **Docker & Docker Compose** - コンテナ化
- **Nginx** - Webサーバー
- **PHP-FPM** - PHPプロセスマネージャー

## 📋 前提条件

- Docker Desktop がインストールされていること
- Docker Compose が利用可能であること
- Git がインストールされていること

## 🚀 セットアップ

### 1. リポジトリのクローン
```bash
git clone [repository-url]
cd Laravel-dev
```

### 2. Dockerコンテナの構築・起動
```bash
# コンテナをビルド
docker compose build

# コンテナを起動（デタッチモード）
docker compose up -d
```

### 3. Laravel依存関係のインストール
```bash
# Composerで依存関係をインストール
docker compose run --rm app composer install
```

### 4. データベースのセットアップ
```bash
# マイグレーション実行
docker compose exec app php artisan migrate

# サンプルデータの投入（オプション）
docker compose exec app php artisan db:seed --class=TaskSeeder
```

### 5. アクセス確認
ブラウザで `http://localhost` にアクセスしてタスク管理画面を確認

## 📖 使用方法

### タスクの作成
1. 左サイドバーの「Add New Task」フォームを使用
2. タスクのタイトル（必須）を入力
3. 説明（オプション）を追加
4. 優先度（Low/Medium/High）を選択
5. 「Add Task」ボタンをクリック

### タスクの管理
- **完了マーク**: タスクのチェックボックスをクリックして完了/未完了を切り替え
- **フィルタリング**: 上部のボタン（All/Pending/Completed）でタスクを絞り込み
- **削除**: タスク右側のゴミ箱アイコンをクリックして削除

### 統計の確認
左サイドバー下部の「Statistics」で以下の情報を確認：
- 総タスク数
- 完了タスク数  
- 未完了タスク数
- 完了率（プログレスバー付き）

## 📁 プロジェクト構造

```
Laravel-dev/
├── docker/
│   ├── nginx/
│   │   └── default.conf          # Nginx設定
│   └── php/
│       └── Dockerfile            # PHP-FPMコンテナ設定
├── src/                          # Laravelアプリケーション
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   └── TaskController.php # タスクコントローラー
│   │   └── Models/
│   │       └── Task.php          # タスクモデル
│   ├── database/
│   │   ├── migrations/           # データベースマイグレーション
│   │   └── seeders/              # サンプルデータ
│   ├── resources/views/
│   │   ├── layouts/
│   │   │   └── app.blade.php     # 共通レイアウト
│   │   └── tasks/
│   │       └── index.blade.php   # タスク一覧画面
│   └── routes/
│       └── web.php               # ルート定義
├── docker-compose.yml            # Docker構成
└── README.md                     # このファイル
```

## 🔗 API エンドポイント

| Method | URI | Action | Route Name |
|--------|-----|--------|------------|
| GET | `/tasks` | タスク一覧表示 | tasks.index |
| POST | `/tasks` | タスク作成 | tasks.store |
| PUT/PATCH | `/tasks/{id}` | タスク更新 | tasks.update |
| DELETE | `/tasks/{id}` | タスク削除 | tasks.destroy |

## 🔧 開発者向け情報

### 開発環境でのコンテナ操作
```bash
# コンテナ内でコマンド実行
docker compose exec app php artisan [command]

# ログ確認
docker compose logs [service-name]

# コンテナの停止
docker compose down

# 完全リセット（ボリューム含む）
docker compose down -v
```

### データベース操作
```bash
# 新しいマイグレーション作成
docker compose exec app php artisan make:migration [migration-name]

# マイグレーションロールバック
docker compose exec app php artisan migrate:rollback

# マイグレーション状態確認
docker compose exec app php artisan migrate:status
```

### 新機能の追加
```bash
# 新しいモデル作成（ファクトリー付き）
docker compose exec app php artisan make:model [ModelName] -f

# 新しいコントローラー作成（リソース付き）
docker compose exec app php artisan make:controller [ControllerName] --resource

# 新しいシーダー作成
docker compose exec app php artisan make:seeder [SeederName]
```

## 🐛 トラブルシューティング

### よくある問題と解決方法

**1. ポート競合エラー**
```bash
# 使用中のポートを確認
netstat -tulnp | grep :80
netstat -tulnp | grep :5432

# docker-compose.ymlでポートを変更
ports:
  - "8080:80"  # 例: 8080ポートに変更
```

**2. 権限エラー**
```bash
# ストレージ権限の修正
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
docker compose exec app chmod -R 775 storage bootstrap/cache
```

**3. データベース接続エラー**
```bash
# PostgreSQLコンテナの確認
docker compose ps
docker compose logs postgres

# データベース接続テスト
docker compose exec app php artisan tinker
>>> DB::connection()->getPdo();
```

**4. Composer依存関係の問題**
```bash
# Composerキャッシュクリア
docker compose exec app composer clear-cache

# 依存関係の再インストール
docker compose exec app composer install --no-cache
```

## 🚧 今後の拡張予定

- 🔐 **ユーザー認証** - 複数ユーザー対応
- 🏷️ **カテゴリ機能** - タスクのカテゴリ分類
- 📅 **期限設定** - タスクの締切日設定
- 🔔 **通知機能** - 締切前のリマインダー
- 📊 **詳細統計** - より詳細な分析・レポート機能
- 💾 **エクスポート機能** - CSV/PDFでのタスクエクスポート
- 🔍 **検索機能** - タスクの全文検索
- 📱 **PWA対応** - モバイルアプリライクな体験

## 📄 ライセンス

このプロジェクトは MIT ライセンスの下で公開されています。

## 🤝 コントリビューション

バグ報告、機能提案、プルリクエストを歓迎します。

1. このリポジトリをフォーク
2. フィーチャーブランチを作成 (`git checkout -b feature/amazing-feature`)
3. 変更をコミット (`git commit -m 'Add some amazing feature'`)
4. ブランチにプッシュ (`git push origin feature/amazing-feature`)
5. プルリクエストを作成

## 📞 サポート

問題が発生した場合は、以下の方法でサポートを受けられます：

- **Issues**: GitHub Issues で問題を報告
- **Discussions**: 機能提案や質問のためのディスカッション
- **Wiki**: 詳細なドキュメントと FAQ

---

**Happy Task Managing! 🎉**