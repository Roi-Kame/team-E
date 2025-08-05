// copilotに作ってもらったコード

// // ユーザー管理
// let users = [];
// // タスク管理
// let tasks = [];
// // フィルタ・ソート
// let filter = { assignee: '', status: '', sort: 'title' };

// // DOM取得
// const usernameInput = document.getElementById('username');
// const addUserBtn = document.getElementById('add-user');
// const userList = document.getElementById('user-list');
// const taskTitleInput = document.getElementById('task-title');
// const taskAssigneeSelect = document.getElementById('task-assignee');
// const taskStatusSelect = document.getElementById('task-status');
// const addTaskBtn = document.getElementById('add-task');
// const filterAssigneeSelect = document.getElementById('filter-assignee');
// const filterStatusSelect = document.getElementById('filter-status');
// const sortTaskSelect = document.getElementById('sort-task');
// const applyFilterBtn = document.getElementById('apply-filter');
// const taskTableBody = document.querySelector('#task-table tbody');

// // ユーザー追加
// addUserBtn.onclick = () => {
//   const name = usernameInput.value.trim();
//   if (!name || users.includes(name)) return;
//   users.push(name);
//   usernameInput.value = '';
//   renderUsers();
//   renderAssigneeSelects();
// };

// function renderUsers() {
//   userList.innerHTML = '';
//   users.forEach(user => {
//     const li = document.createElement('li');
//     li.textContent = user;
//     userList.appendChild(li);
//   });
// }

// function renderAssigneeSelects() {
//   [taskAssigneeSelect, filterAssigneeSelect].forEach(select => {
//     select.innerHTML = '<option value="">担当者を選択</option>';
//     users.forEach(user => {
//       const opt = document.createElement('option');
//       opt.value = user;
//       opt.textContent = user;
//       select.appendChild(opt);
//     });
//   });
// }

// // タスク追加
// addTaskBtn.onclick = () => {
//   const title = taskTitleInput.value.trim();
//   const assignee = taskAssigneeSelect.value;
//   const status = taskStatusSelect.value;
//   if (!title || !assignee) return;
//   tasks.push({ title, assignee, status });
//   taskTitleInput.value = '';
//   taskAssigneeSelect.value = '';
//   taskStatusSelect.value = '未着手';
//   renderTasks();
// };

// // タスク一覧表示
// function renderTasks() {
//   let filtered = tasks.filter(task => {
//     return (!filter.assignee || task.assignee === filter.assignee) &&
//            (!filter.status || task.status === filter.status);
//   });
//   if (filter.sort === 'title') {
//     filtered.sort((a, b) => a.title.localeCompare(b.title));
//   } else if (filter.sort === 'assignee') {
//     filtered.sort((a, b) => a.assignee.localeCompare(b.assignee));
//   } else if (filter.sort === 'status') {
//     filtered.sort((a, b) => a.status.localeCompare(b.status));
//   }
//   taskTableBody.innerHTML = '';
//   filtered.forEach((task, idx) => {
//     const tr = document.createElement('tr');
//     tr.innerHTML = `<td>${task.title}</td><td>${task.assignee}</td><td>${task.status}</td>
//       <td><button onclick="editTask(${idx})">編集</button> <button onclick="deleteTask(${idx})">削除</button></td>`;
//     taskTableBody.appendChild(tr);
//   });
// }

// // 編集・削除
// window.editTask = function(idx) {
//   const task = tasks[idx];
//   taskTitleInput.value = task.title;
//   taskAssigneeSelect.value = task.assignee;
//   taskStatusSelect.value = task.status;
//   addTaskBtn.textContent = '更新';
//   addTaskBtn.onclick = () => {
//     task.title = taskTitleInput.value.trim();
//     task.assignee = taskAssigneeSelect.value;
//     task.status = taskStatusSelect.value;
//     addTaskBtn.textContent = '追加';
//     addTaskBtn.onclick = addTask;
//     taskTitleInput.value = '';
//     taskAssigneeSelect.value = '';
//     taskStatusSelect.value = '未着手';
//     renderTasks();
//   };
// };
// window.deleteTask = function(idx) {
//   tasks.splice(idx, 1);
//   renderTasks();
// };

// // フィルタ・ソート
// applyFilterBtn.onclick = () => {
//   filter.assignee = filterAssigneeSelect.value;
//   filter.status = filterStatusSelect.value;
//   filter.sort = sortTaskSelect.value;
//   renderTasks();
// };

// // 初期表示
// function addTask() {
//   const title = taskTitleInput.value.trim();
//   const assignee = taskAssigneeSelect.value;
//   const status = taskStatusSelect.value;
//   if (!title || !assignee) return;
//   tasks.push({ title, assignee, status });
//   taskTitleInput.value = '';
//   taskAssigneeSelect.value = '';
//   taskStatusSelect.value = '未着手';
//   renderTasks();
// }
// addTaskBtn.onclick = addTask;
// renderUsers();
// renderAssigneeSelects();
// renderTasks();


// 新規登録時入力項目に未入力等のエラーがないか検証
function validateForm() {
    let username = document.getElementById("username");
    // 未入力と空白のみの入力をエラーに
    if (username.value.trim() === "") {
        document.getElementById("error").style.display = "block";
        return false;
    } else {
        document.getElementById("error").style.display = "none";
        return true;
    }


}


function create_file() {
    console.log("関数呼び出し成功");
    let file_name = document.getElementById("file-name");
    if (file_name.value.trim() === "") {
        document.getElementById("error").style.display = "block";
        return false;
    } else {
        document.getElementById("error").style.display = "none";
        return true;
    }
}