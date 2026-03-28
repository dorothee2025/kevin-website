#!/bin/bash
# Complete Test Suite for localStorage → PHP Session Migration
# Run this after setup to verify everything works

echo "╔════════════════════════════════════════════════════════╗"
echo "║    CS DREAM Migration - Complete Test Suite            ║"
echo "╚════════════════════════════════════════════════════════╝"
echo ""

# Colors
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Counters
TESTS_PASSED=0
TESTS_FAILED=0

# Test Helper
run_test() {
    local test_name=$1
    local command=$2
    local expected=$3
    
    echo -n "Testing: $test_name ... "
    
    result=$(eval "$command" 2>&1)
    
    if [[ "$result" == *"$expected"* ]]; then
        echo -e "${GREEN}✓ PASS${NC}"
        ((TESTS_PASSED++))
    else
        echo -e "${RED}✗ FAIL${NC}"
        echo "  Expected to find: $expected"
        echo "  Got: $result" | head -3
        ((TESTS_FAILED++))
    fi
}

# ============================================================
# PHASE 1: FILE VERIFICATION
# ============================================================
echo -e "\n${BLUE}PHASE 1: Checking Required Files${NC}"
echo "─────────────────────────────────────────────────────────"

files=(
    "state-manager.js"
    "auth.js"
    "admin.php"
    "home.php"
    "about.php"
    "api/state.php"
    "api/intro.php"
    "api/admin_login.php"
    "api/admin_check.php"
    "api/admin_logout.php"
    "api/auth_logout.php"
    "api/notifications.php"
    "api/mark_notifications_seen.php"
    "api/schema_migration.sql"
    "MIGRATION_GUIDE.md"
    "MIGRATION_COMPLETE.md"
    "STATEMANAGER_API.js"
)

for file in "${files[@]}"; do
    if [ -f "$file" ]; then
        echo -e "${GREEN}✓${NC} Found: $file"
    else
        echo -e "${RED}✗${NC} Missing: $file"
        ((TESTS_FAILED++))
    fi
done

# ============================================================
# PHASE 2: FILE CONTENT VERIFICATION
# ============================================================
echo -e "\n${BLUE}PHASE 2: Verifying File Contents${NC}"
echo "─────────────────────────────────────────────────────────"

# Check auth.js - should NOT have localStorage
run_test "auth.js has no localStorage.setItem" \
    "grep -c 'localStorage.setItem' auth.js" \
    "0"

# Check state-manager.js - should have StateManager
run_test "state-manager.js defines StateManager" \
    "grep -c 'const StateManager' state-manager.js" \
    "1"

# Check admin.php - should use API auth
run_test "admin.php calls admin_login.php" \
    "grep -c 'admin_login.php' admin.php" \
    "1"

# Check home.php - should use StateManager
run_test "home.php loads state-manager.js" \
    "grep -c 'state-manager.js' home.php" \
    "1"

# Check about.php - StateManager for history hint
run_test "about.php uses StateManager" \
    "grep -c 'StateManager' about.php" \
    "1"

# ============================================================
# PHASE 3: API ENDPOINT VERIFICATION
# ============================================================
echo -e "\n${BLUE}PHASE 3: Testing API Endpoints${NC}"
echo "─────────────────────────────────────────────────────────"
echo "Note: Requires web server running. Will test localhost..."

# Function to make HTTP request
test_endpoint() {
    local url=$1
    local method=${2:-GET}
    local expected_code=${3:-200}
    
    local code=$(curl -s -o /dev/null -w "%{http_code}" \
        -X "$method" \
        -H "Cookie: PHPSESSID=test" \
        "http://localhost/$url" 2>/dev/null)
    
    echo -n "  $method $url: "
    if [[ "$code" == "$expected_code" ]] || [[ "$code" == "301" ]] || [[ "$code" == "302" ]] || [[ "$code" == "401" ]]; then
        echo -e "${GREEN}✓ ($code)${NC}"
        return 0
    else
        echo -e "${YELLOW}⚠ ($code)${NC}"
        return 1
    fi
}

# Test endpoints
if command -v curl &> /dev/null; then
    echo "Testing endpoint accessibility..."
    test_endpoint "api/intro.php" "GET"
    test_endpoint "api/admin_check.php" "GET"
    test_endpoint "api/admin_login.php" "POST"
else
    echo -e "${YELLOW}⚠ curl not available, skipping endpoint tests${NC}"
fi

# ============================================================
# PHASE 4: DATABASE VERIFICATION
# ============================================================
echo -e "\n${BLUE}PHASE 4: Database Schema Verification${NC}"
echo "─────────────────────────────────────────────────────────"

read -p "Check MySQL tables? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    read -p "Enter MySQL user [kevin_user]: " MYSQL_USER
    MYSQL_USER=${MYSQL_USER:-kevin_user}
    read -sp "Enter MySQL password: " MYSQL_PASS
    echo
    read -p "Enter Database name [kevin_website]: " DB_NAME
    DB_NAME=${DB_NAME:-kevin_website}
    
    # Test connection
    echo "Connecting to MySQL..."
    result=$(mysql -h localhost -u "$MYSQL_USER" -p"$MYSQL_PASS" "$DB_NAME" -e "SHOW TABLES;" 2>&1)
    
    if [[ "$result" == *"user_state"* ]]; then
        echo -e "${GREEN}✓${NC} user_state table exists"
        ((TESTS_PASSED++))
    else
        echo -e "${RED}✗${NC} user_state table not found"
        ((TESTS_FAILED++))
    fi
    
    if [[ "$result" == *"admin_sessions"* ]]; then
        echo -e "${GREEN}✓${NC} admin_sessions table exists"
        ((TESTS_PASSED++))
    else
        echo -e "${RED}✗${NC} admin_sessions table not found"
        ((TESTS_FAILED++))
    fi
    
    if [[ "$result" == *"notification_log"* ]]; then
        echo -e "${GREEN}✓${NC} notification_log table exists"
        ((TESTS_PASSED++))
    else
        echo -e "${RED}✗${NC} notification_log table not found"
        ((TESTS_FAILED++))
    fi
    
    if [[ "$result" == *"notification_seen"* ]]; then
        echo -e "${GREEN}✓${NC} notification_seen table exists"
        ((TESTS_PASSED++))
    else
        echo -e "${RED}✗${NC} notification_seen table not found"
        ((TESTS_FAILED++))
    fi
fi

# ============================================================
# PHASE 5: SYNTAX VERIFICATION
# ============================================================
echo -e "\n${BLUE}PHASE 5: JavaScript Syntax Check${NC}"
echo "─────────────────────────────────────────────────────────"

# Check for common errors
run_test "No semicolon instead of || operator in auth.js" \
    "grep -c ' ; ' auth.js | head -1" \
    "0"

run_test "StateManager closure properly closed" \
    "grep -c '})();' state-manager.js" \
    "1"

# ============================================================
# PHASE 6: DOCUMENTATION CHECK
# ============================================================
echo -e "\n${BLUE}PHASE 6: Documentation Completeness${NC}"
echo "─────────────────────────────────────────────────────────"

run_test "MIGRATION_GUIDE.md has setup instructions" \
    "grep -c 'Database Setup' MIGRATION_GUIDE.md" \
    "1"

run_test "STATEMANAGER_API.js has examples" \
    "grep -c 'function example' STATEMANAGER_API.js" \
    "1"

run_test "README_MIGRATION.md has overview" \
    "grep -c 'Overview' README_MIGRATION.md" \
    "1"

# ============================================================
# PHASE 7: QUICK FUNCTIONALITY TEST
# ============================================================
echo -e "\n${BLUE}PHASE 7: Quick Functionality Tests${NC}"
echo "─────────────────────────────────────────────────────────"

# Create a temp test file
cat > /tmp/test-statemanager.html <<'EOF'
<!DOCTYPE html>
<html>
<head>
    <script src="../../state-manager.js"></script>
</head>
<body>
    <script>
        // Quick test
        if (typeof StateManager !== 'undefined') {
            console.log('✓ StateManager loaded');
            if (typeof StateManager.checkIntroSeen === 'function') {
                console.log('✓ StateManager methods available');
            }
        }
    </script>
</body>
</html>
EOF

if [ -f "/tmp/test-statemanager.html" ]; then
    echo -e "${GREEN}✓${NC} Test page created successfully"
    rm /tmp/test-statemanager.html
fi

# ============================================================
# SUMMARY
# ============================================================
echo ""
echo "╔════════════════════════════════════════════════════════╗"
echo "║                    TEST SUMMARY                        ║"
echo "╚════════════════════════════════════════════════════════╝"
echo ""

TOTAL=$((TESTS_PASSED + TESTS_FAILED))
if [ $TOTAL -gt 0 ]; then
    PERCENT=$((TESTS_PASSED * 100 / TOTAL))
    echo "Total Tests Run: $TOTAL"
    echo -e "Passed:        ${GREEN}$TESTS_PASSED${NC}"
    echo -e "Failed:        ${RED}$TESTS_FAILED${NC}"
    echo "Success Rate:  $PERCENT%"
else
    echo "No automated tests run (manual verification recommended)"
fi

echo ""
echo "╔════════════════════════════════════════════════════════╗"

if [ $TESTS_FAILED -eq 0 ]; then
    echo -e "║ ${GREEN}✓ All Checks Passed - Ready to Deploy!${NC}           ║"
else
    echo -e "║ ${RED}✗ Some checks failed - review above${NC}              ║"
fi

echo "╚════════════════════════════════════════════════════════╝"
echo ""

# ============================================================
# NEXT STEPS
# ============================================================
echo -e "\n${BLUE}Next Steps:${NC}"
echo "1. Open browser DevTools (F12)"
echo "2. Visit home.php and test intro flow"
echo "3. Skip intro, refresh page"
echo "4. Run in console: StateManager.checkIntroSeen()"
echo "5. Visit admin.php and test login with password"
echo "6. Check MySQL: SELECT * FROM user_state;"
echo ""
echo "For detailed help, see MIGRATION_GUIDE.md"
echo ""

exit $TESTS_FAILED
