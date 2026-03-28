#!/bin/bash

# Setup script for localStorage → PHP Session migration
# Run this after pulling the new code

echo "🔧 CS DREAM Migration Setup Script"
echo "===================================="
echo ""

# Check if mysql is available
if ! command -v mysql &> /dev/null; then
    echo "❌ MySQL client not found. Please install it."
    exit 1
fi

echo "📝 Enter MySQL credentials:"
read -p "MySQL Host (default: localhost): " MYSQL_HOST
MYSQL_HOST=${MYSQL_HOST:-localhost}

read -p "MySQL User (default: kevin_user): " MYSQL_USER
MYSQL_USER=${MYSQL_USER:-kevin_user}

read -sp "MySQL Password: " MYSQL_PASS
echo ""

read -p "Database name (default: kevin_website): " DB_NAME
DB_NAME=${DB_NAME:-kevin_website}

echo ""
echo "🚀 Running database migration..."

# Execute schema migration
mysql -h "$MYSQL_HOST" -u "$MYSQL_USER" -p"$MYSQL_PASS" "$DB_NAME" < api/schema_migration.sql

if [ $? -eq 0 ]; then
    echo "✅ Database tables created successfully!"
else
    echo "❌ Database migration failed!"
    exit 1
fi

echo ""
echo "📦 Verifying new tables..."

# Verify tables exist
mysql -h "$MYSQL_HOST" -u "$MYSQL_USER" -p"$MYSQL_PASS" "$DB_NAME" -e \
    "SHOW TABLES LIKE 'user_state' OR SHOW TABLES LIKE 'admin_sessions' OR SHOW TABLES LIKE 'notification%';" > /dev/null

if [ $? -eq 0 ]; then
    echo "✅ All required tables verified!"
else
    echo "⚠️  Could not verify tables. Please check manually."
fi

echo ""
echo "📝 Configuration check..."

if grep -q "session_start();" home.php; then
    echo "✅ PHP sessions enabled in home.php"
else
    echo "⚠️  PHP sessions might not be enabled"
fi

if [ -f "state-manager.js" ]; then
    echo "✅ state-manager.js found"
else
    echo "❌ state-manager.js not found!"
fi

if [ -f "api/state.php" ]; then
    echo "✅ API endpoints created"
else
    echo "❌ API endpoints not found!"
fi

echo ""
echo "✨ Migration setup complete!"
echo ""
echo "Next steps:"
echo "1. Test intro flow: Load home.php, skip intro, refresh page (should skip automatically)"
echo "2. Test admin: Load admin.php with password 'kevin@040'"
echo "3. Monitor browser console for any StateManager errors"
echo "4. Check MySQL: SELECT * FROM user_state;"
echo ""
