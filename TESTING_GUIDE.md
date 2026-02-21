# Testing Guide - नए Features को Test करें

## 🧪 Manual Testing Steps

### 1️⃣ Database Setup

```bash
# Database migrations चलाएं:
php artisan migrate --force

# आउटपुट में ये दिखेगा:
✓ 2025_02_21_000001_add_status_to_leads_table
✓ 2025_02_21_000002_add_assigned_to_leads_table  
✓ 2025_02_21_000003_create_activity_logs_table
✓ 2025_02_21_000004_add_performance_indexes
```

---

### 2️⃣ Admin Dashboard Testing

#### Test Case 1: Admin Login और Dashboard देखना
```
Steps:
1. http://yoursite.com/admin/login खोलें
2. Admin credentials से login करें
3. /admin/dashboard पर redirect होगा
4. Dashboard में देखें:
   ✓ Subadmins count
   ✓ Total leads count
   ✓ Leads this month
   ✓ Completed leads
   ✓ Status breakdown chart
   ✓ Weekly overview
   ✓ Recent leads list
   ✓ Activity feed

Expected: सब कुछ के साथ सुंदर dashboard दिखे
```

#### Test Case 2: Activity Logs View करना
```
Steps:
1. Admin dashboard से "View Activity Logs" क्लिक करें
2. या directly: http://yoursite.com/admin/activity-logs
3. देखें:
   ✓ सभी activities list हों
   ✓ User filter काम करे
   ✓ Action filter काम करे
   ✓ Model type filter काम करे
   ✓ Date range filter काम करे
   ✓ Pagination काम करे

Expected: Activity logs filtered और पaginat हों
```

---

### 3️⃣ Leads Management Testing

#### Test Case 3: Lead Create करते समय Status Set करना
```
Steps:
1. /subadmin/leads/create खोलें
2. Form fill करें:
   - Name: "Test Lead"
   - Email: "test@example.com"
   - Mobile: "9876543210"
   - DOB: "01/01/1990"
   - Gender: "Male"
3. Submit करें
4. Success message देखें
5. Activity log में entry check करें

Expected: Lead बन जाए, activity log में "created" दिखे
```

#### Test Case 4: Lead Edit करते समय Status Change करना
```
Steps:
1. /subadmin/leads में जाएं
2. किसी lead को edit करें
3. Status field में dropdown है
4. Status बदलें: new → in_progress
5. Save करें
6. Success message देखें
7. Activity logs check करें

Expected: 
✓ Lead status updated हो
✓ Activity log में "status_changed" entry हो
✓ Old और new value दिखें
```

#### Test Case 5: Lead को Subadmin को Assign करना
```
Steps:
1. Lead edit page खोलें
2. "Assign To" dropdown में subadmin select करें
3. Save करें
4. Success message देखें
5. Activity logs check करें

Expected:
✓ Lead assigned हो
✓ Activity log में "assigned" entry हो
✓ Old और new user दिखें
```

---

### 4️⃣ Search & Filter Testing

#### Test Case 6: Search by Name
```
Steps:
1. /subadmin/leads खोलें
2. Search box में कोई lead का नाम डालें
3. Filter button क्लिक करें
4. Results देखें

Expected: सिर्फ matching leads दिखें
```

#### Test Case 7: Filter by Status
```
Steps:
1. /subadmin/leads खोलें
2. Status dropdown से "completed" select करें
3. Filter button क्लिक करें
4. Results देखें

Expected: सिर्फ completed leads दिखें
```

#### Test Case 8: Filter by Assigned User
```
Steps:
1. /subadmin/leads खोलें
2. Assigned dropdown से कोई admin select करें
3. Filter button क्लिक करें
4. Results देखें

Expected: सिर्फ उस user को assigned leads दिखें
```

#### Test Case 9: Combine Multiple Filters
```
Steps:
1. /subadmin/leads खोलें
2. Search: "john"
3. Status: "in_progress"
4. Assigned: "Admin1"
5. Filter button क्लिक करें
6. Results देखें

Expected: सभी 3 filters के अनुसार results
```

#### Test Case 10: Reset Filters
```
Steps:
1. Filters apply करें
2. Reset button क्लिक करें
3. सभी filters clear हों
4. सभी leads दिखें

Expected: सभी leads back to original state
```

---

### 5️⃣ Subadmin Dashboard Testing

#### Test Case 11: Subadmin Dashboard देखना
```
Steps:
1. Subadmin से login करें
2. /subadmin/dashboard खोलें
3. Dashboard में देखें:
   ✓ Total leads (system में)
   ✓ Assigned to me count
   ✓ In progress count
   ✓ Completed count
   ✓ My leads by status
   ✓ Completion rate %
   ✓ Recent leads table

Expected: सभी metrics personal होंि
```

---

### 6️⃣ File Upload Testing

#### Test Case 12: Valid File Upload
```
Steps:
1. Lead document create page खोलें
2. Valid image/PDF upload करें (< 2MB)
3. Submit करें
4. Success message देखें
5. Activity logs check करें

Expected: 
✓ File uploaded हो
✓ Activity log में "document_uploaded" दिखे
```

#### Test Case 13: Invalid File Upload
```
Steps:
1. Document upload page खोलें
2. Large file try करें (> 5MB)
3. Submit करें
4. Error message देखें

Expected: Error message: "File too large"
```

---

### 7️⃣ Pagination Testing

#### Test Case 14: Pagination काम करना
```
Steps:
1. Leads list में जाएं (अगर 15 से ज्यादा leads हों)
2. Page numbers देखें
3. Next page click करें
4. Next set of leads दिखें
5. Previous click करें
6. Back to page 1

Expected: Pagination smooth काम करे
```

---

### 8️⃣ Status Badges Testing

#### Test Case 15: Status Color Coding
```
Steps:
1. Leads list में जाएं
2. Status column देखें:
   ✓ New = Blue badge
   ✓ In Progress = Yellow badge
   ✓ Completed = Green badge
   ✓ Rejected = Red badge

Expected: सभी colors सही दिखें
```

---

### 9️⃣ Notifications Testing

#### Test Case 16: Success Notification
```
Steps:
1. कोई lead create करें
2. Success message दिखे
3. Dismissible button fix करें
4. Message disappear हो जाए

Expected: Clean notification show + dismiss हो
```

---

## 📋 API Testing (Optional)

### Using Postman या curl:

#### Create Lead with Status
```bash
curl -X POST http://yoursite.com/subadmin/leads \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "mobile": "9876543210",
    "status": "new",
    "assigned_to": 1
  }'
```

#### Update Lead Status
```bash
curl -X PATCH http://yoursite.com/subadmin/leads/1/status \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"status": "completed"}'
```

#### Assign Lead
```bash
curl -X PATCH http://yoursite.com/subadmin/leads/1/assign \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"assigned_to": 2}'
```

#### Get Activity Logs
```bash
curl -X GET "http://yoursite.com/admin/activity-logs?user_id=1&status=created" \
  -H "Authorization: Bearer {token}"
```

---

## ✅ Final Checklist

Database:
- [ ] सभी migrations run हों
- [ ] activity_logs table exist करे
- [ ] leads table में status column हो
- [ ] leads table में assigned_to column हो

Controllers:
- [ ] LeadController updated हो
- [ ] ActivityLogController exist करे
- [ ] LeadDocumentController updated हो

Models:
- [ ] Lead model में status हो
- [ ] Lead model में assignedTo relationship हो
- [ ] ActivityLog model exist करे

Views:
- [ ] Admin dashboard updated हो
- [ ] Subadmin dashboard updated हो
- [ ] Activity logs view exist करे
- [ ] Leads index में filters हों
- [ ] Leads edit में status & assign fields हों

Routes:
- [ ] PATCH /subadmin/leads/{lead}/status काम करे
- [ ] PATCH /subadmin/leads/{lead}/assign काम करे
- [ ] GET /admin/activity-logs काम करे

Features:
- [ ] Search काम करे
- [ ] Filter काम करे
- [ ] Status change काम करे
- [ ] Assignment काम करे
- [ ] Activity logging काम करे
- [ ] Pagination काम करे
- [ ] Notifications दिखें
- [ ] Dashboard analytics दिखें

---

## 🐛 Debugging Tips

अगर कुछ काम नहीं कर रहा:

### 1. Migrations Check करें:
```bash
php artisan migrate:status
# Check if all migrations are "Ran"
```

### 2. Routes Check करें:
```bash
php artisan route:list | grep leads
# Check if new routes exist
```

### 3. Models Check करें:
```bash
php artisan tinker
>>> Lead::first()->status;
# Check if status field accessible है
```

### 4. Activity Logs Check करें:
```bash
php artisan tinker
>>> DB::table('activity_logs')->count();
# Check if logs being created
```

### 5. Laravel Logs Check करें:
```bash
tail -f storage/logs/laravel.log
# Real-time error monitoring
```

---

## 🚀 Go-Live Checklist

Before production:

- [ ] सब कुछ locally test किया?
- [ ] Database backup ले लिया?
- [ ] Migrations को version control में commit किया?
- [ ] Environment variables set किये?
- [ ] Error logging configured है?
- [ ] Performance testing की?
- [ ] Security audit की?
- [ ] User documentation बनाई?

---

**Happy Testing! 🎉**
