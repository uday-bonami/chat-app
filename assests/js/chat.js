let currentWindowClass = null;
let currentUserId = null;
let currentUsername = null;
let uploadFileArray = [];
let callerId = null;
const callButtons = document.getElementsByClassName("join-call");
const endCallbtns = document.getElementsByClassName("end-call");
const acceptCall = document.getElementById("accept-call");
const ws = new WebSocket("ws://192.168.101.72:8080");

function updateMessageStatus() {
  const statusData = { sender: currentUserId, reciver: userId };
  fetch("./api/message.php", {
    method: "POST",
    headers: {
      "content-type": "application/json;charset=UTF-8",
    },
    body: JSON.stringify(statusData),
  }).then((res) => {
    res.text().then((data) => {
      console.log(data);
    });
  });
}

acceptCall.onclick = () => {
  const acceptCallData = {
    type: "acceptcall",
    to: callerId,
    from: userId,
    username: username,
  };
  console.log(acceptCallData);
  ws.send(JSON.stringify(acceptCallData));
  window.location.replace("./call.php?callId=" + callerId);
};

for (let callButton of callButtons) {
  callButton.onclick = () => {
    const callingModel = document.getElementById("call-window");
    callingModel.style.display = "flex";
    const sendData = {
      type: "call",
      to: currentUserId,
      from: userId,
      username: username,
    };
    ws.send(JSON.stringify(sendData));
  };
}
for (let endCall of endCallbtns) {
  endCall.onclick = () => {
    const callingModal = document.getElementById("call-window");
    callingModal.style.display = "none";
    const endCallData = {
      type: "endcall",
      to: currentUserId,
      from: userId,
      username: username,
    };
    ws.send(JSON.stringify(endCallData));
    closeCallingModal();
  };
}

function removeMessageCount() {
  const fromLi = document.getElementById(`${currentUserId}`);
  const messageNumber = fromLi.getElementsByClassName("message-number")[0];
  if (messageNumber) {
    messageNumber.remove();
  }
}

function changeWindow() {
  const connectionChat = document.getElementsByClassName("connection");
  for (let chat of connectionChat) {
    chat.onclick = () => {
      const selectedWindow = document.getElementById("selected-window");
      if (selectedWindow) {
        selectedWindow.removeAttribute("id");
      }
      currentWindowClass = currentWindowClass
        ? currentWindowClass
        : "empty-chat-window";
      document.getElementsByClassName(currentWindowClass)[0].style.display =
        "none";
      const selectedELement = document.getElementsByClassName(chat.id)[0];
      selectedELement.id = "selected-window";
      selectedELement.style.display = "block";
      currentUserId = chat.id;
      currentWindowClass = `connection-chat ${chat.id}`;
      updateMessageStatus();
      removeMessageCount();
    };
  }
}

function removeHTML(message) {
  if (message.includes("<") || message.includes(">")) {
    const lt = "&lt;";
    const gt = "&gt;";
    while (true) {
      if (message.includes("<")) {
        message = message.replace("<", lt);
      } else if (message.includes(">")) {
        message = message.replace(">", gt);
      } else {
        break;
      }
    }
  }
  return message;
}

function getTime() {
  const date = new Date();
  let hour = date.getHours();
  const minute = date.getMinutes();
  let ampm = "am";
  if (hour > 12) {
    ampm = "pm";
    hour = hour - 12;
  }
  return `${hour}:${minute}${ampm}`;
}

function getAmPmTime(hour) {
  if (hour > 12) {
    return "pm";
  }
  return "am";
}

function getCurrentTime(timestamp) {
  const date = new Date(timestamp * 1000);
  let hour = date.getHours();
  let min = date.getMinutes();
  const ampm = getAmPmTime(hour);
  if (hour > 12) {
    hour = hour - 12;
  }
  let time = `${hour}:${min}${ampm}`;
  return time;
}

function createSendedMessageBubble(messageData) {
  const bubbleContainer = document.createElement("div");
  bubbleContainer.className = "col-12 mt-5";
  const time = getTime();
  const bubble = `
  <div class="row justify-content-end">
    <div class="col-4">
      <p class="chat_timing text-end">${time}</p>
      <p class="text-white chat_box3 py-2 text-center mt-1">${removeHTML(
        messageData["message"]
      )}</p>
    </div>
  </div>
  `;
  bubbleContainer.innerHTML = bubble;
  const openedChatWindow =
    document.getElementsByClassName(currentWindowClass)[0];
  openedChatWindow.appendChild(bubbleContainer);
}

function createMessageCount(message) {
  const from = message["from"];
  const fromLi = document.getElementById(`${from}`);
  console.log(fromLi.getElementsByClassName("message-number"));
  if (fromLi.getElementsByClassName("message-number").length != 0) {
    const messageNumber = fromLi.getElementsByClassName("message-number")[0];
    messageNumber.innerHTML = parseInt(messageNumber.innerHTML) + 1;
  } else {
    const messageNumber = document.createElement("div");
    console.log(fromLi);
    messageNumber.innerHTML = 1;
    messageNumber.className = "message-number";
    fromLi.getElementsByClassName("info")[0].appendChild(messageNumber);
  }
}

function createReciverMessageBubble(messageData) {
  const bubbleContainer = document.createElement("div");
  const time = getCurrentTime(messageData["time"]);
  const id = messageData["from"];
  bubbleContainer.className =
    "col-7 chat_container-3-semi2 mt-5 d-flex align-items-start";
  console.log(messageData);
  const bubble = `
    <img style="width: 50px; height: 50px; border-radius: 50%" src="./profile_img/default-avatar.png" class="img-fluid">
    <div class="ms-3">
      <div class="d-flex align-items-end">
        <p class="chat_container-3-semi2-semi1-para1">${
          messageData["username"]
        }</p>
        <p class="chat_timing ms-3">${time}</p>
      </div>
      <div class="chat_box2 p-4 mt-2">
        <p class="chat_container-3-semi2-semi2-para2">${removeHTML(
          messageData["message"]
        )}</p>
      </div>
    </div>`;
  bubbleContainer.innerHTML = bubble;
  const openedChatWindow = document.getElementsByClassName(
    "connection-chat " + id
  )[0];
  if (openedChatWindow) {
    openedChatWindow.appendChild(bubbleContainer);
  }
}

function scrollSmoothToBottom(id) {
  var div = document.getElementById(id);
  $("#" + id).animate(
    {
      scrollTop: div.scrollHeight + 100 - div.clientHeight,
    },
    500
  );
}

function closeCallingModal() {
  const modals = document.getElementsByClassName("call-window");
  for (let modal of modals) {
    modal.style.display = "none";
  }
}

function stablishConnection() {
  const sendButton = document.getElementById("send-msg-btn");
  const inputBox = document.getElementById("chat-input");

  const setOnline = (id) => {
    const status = document.getElementById(`online-status-${id}`);
    const last_seen = document.getElementById(`last-seen-${id}`);
    status.className = "active";
    last_seen.innerHTML = "Online";
  };

  const setOffline = (data) => {
    const id = data["userId"];
    const status = document.getElementById(`online-status-${id}`);
    const last_seen = document.getElementById(`last-seen-${id}`);
    status.className = "unactive";
    last_seen.innerHTML = "Last seen at " + getCurrentTime(data["last_seen"]);
  };

  const sendMessage = () => {
    const message = inputBox.value;
    const fileupload = document.getElementById("upload-file-input");
    if (message == "" && fileupload.value) {
      uploadFile();
      console.log(uploadFileArray);
      // if (uploadFileArray.length !== 0) {
      //   ws.send(JSON.stringify(uploadFileArray[0]));
      // }
    } else {
      if (message !== "" && currentUserId) {
        const messageData = {
          type: "message",
          from: userId,
          to: currentUserId,
          username: username,
          message: message,
        };
        createSendedMessageBubble(messageData);
        ws.send(JSON.stringify(messageData));
        inputBox.value = "";
        scrollSmoothToBottom("chat-window");
      }
    }
  };

  inputBox.addEventListener("keyup", (e) => {
    if (e.keyCode === 13) {
      sendMessage();
    }
  });

  sendButton.onclick = () => {
    sendMessage();
  };

  ws.onopen = function (e) {
    const connectionData = JSON.stringify({
      userId: userId,
      type: "connect",
    });
    ws.send(connectionData);
    console.log("Connection established!");
  };

  ws.onmessage = function (e) {
    const message = JSON.parse(e.data);
    console.log(message);
    if (message["type"] == "connection") {
      setOnline(message["userId"]);
    } else if (message["type"] == "disconnection") {
      setOffline(message);
    } else if (message["type"] == "call") {
      document.getElementById("recive-call-window").style.display = "flex";
      callerId = message["from"];
      document.getElementById("caller-name").innerText = message["username"];
    } else if (message["type"] == "acceptcall") {
      window.location.replace("./call.php?callId=" + message["from"]);
    } else if (message["type"] == "message") {
      if (message["isFile"]) {
        createReciverImageBubble(message);
      } else {
        createReciverMessageBubble(message);
      }
      if (currentUserId != message["from"]) {
        createMessageCount(message);
      }
      if (message["from"] == currentUserId) {
        updateMessageStatus();
      }
      scrollSmoothToBottom("chat-window");
    } else if (message["type"] == "endcall") {
      closeCallingModal();
    }
  };
}

function createReciverImageBubble(messageData) {
  const url = messageData["url"];
  const time = getCurrentTime(messageData["time"]);
  const id = messageData["from"];
  const bubbleContainer = document.createElement("div");
  bubbleContainer.className =
    "col-7 chat_container-3-semi2 mt-5 d-flex align-items-start";
  console.log(messageData);
  let bubble;
  if (messageData["format"] == "img") {
    bubble = `
    <img style="width: 50px; height: 50px; border-radius: 50%" src="./profile_img/default-avatar.png" class="img-fluid">
    <div class="ms-3">
      <div class="d-flex align-items-end">
        <p class="chat_container-3-semi2-semi1-para1">${messageData["username"]}</p>
        <p class="chat_timing ms-3">${time}</p>
      </div>
      <div class="chat_box2 p-4 mt-2">
      <a href="${url}" download>
          <div class="chat_box2 p-4 mt-2">
              <div class="hover_button">
                  <i class="fa-solid fa-cloud-arrow-down"></i>
              </div>
              <img src="${url}" style="width: 300px; height: auto" />
          </div>
      </a>
      </div>
    </div>`;
  } else {
    bubble = `
    <img style="width: 50px; height: 50px; border-radius: 50%" src="./profile_img/default-avatar.png" class="img-fluid">
    <div class="ms-3">
      <div class="d-flex align-items-end">
        <p class="chat_container-3-semi2-semi1-para1">${messageData["username"]}</p>
        <p class="chat_timing ms-3">${time}</p>
      </div>
      <div class="chat_box2 p-4 mt-2">
      <video width="320" height="240" controls>
          <source src="${url}" />
      </video>
    </div>
    </div>
    `;
  }

  bubbleContainer.innerHTML = bubble;
  const openedChatWindow = document.getElementsByClassName(
    "connection-chat " + id
  )[0];
  if (openedChatWindow) {
    openedChatWindow.appendChild(bubbleContainer);
  }
  scrollSmoothToBottom("chat-window");
}

function createSendedImageBubble(data) {
  const url = data["url"];
  const bubbleContainer = document.createElement("div");
  bubbleContainer.className = "col-12 mt-5";
  const time = getTime();
  let bubble;
  if (data["format"] == "img") {
    bubble = `
    <div class="row justify-content-end">
      <div class="col-2">
        <p class="chat_timing text-end">${time}</p>
        <img src="${url}" class="img-fluid  send_image" />
      </div>
    </div>
    `;
  } else {
    bubble = `
      <div class="row justify-content-end">
        <div class="col-2">
          <p class="chat_timing text-end">${time}</p>
        <div class="chat_box2 p-4 mt-2">
          <video width="320" height="240" controls>
              <source src="${url}" />
          </video>
        </div>
      </div>
      `;
  }
  bubbleContainer.innerHTML = bubble;
  const openedChatWindow =
    document.getElementsByClassName(currentWindowClass)[0];
  openedChatWindow.appendChild(bubbleContainer);
  scrollSmoothToBottom("chat-window");
}

function uploadFile() {
  const formData = new FormData();
  console.log("upload");
  const fileupload = document.getElementById("upload-file-input");
  formData.append("file", fileupload.files[0]);
  fetch("./api/uploadFile.php", {
    method: "POST",
    body: formData,
  }).then((res) => {
    res.text().then((data) => {
      data = JSON.parse(data);
      if (!data["error"]) {
        data["isFile"] = true;
        data["from"] = userId;
        data["to"] = currentUserId;
        data["username"] = username;
        data["type"] = "message";
        uploadFileArray.push(data);
        createSendedImageBubble(data);
        ws.send(JSON.stringify(data));
        fileupload.value = null;
      } else {
        alert(data["message"]);
      }
    });
  });
}

function setUpload() {
  const fileUpload = document.getElementById("upload-file-input");
  fileUpload.onchange = () => {
    console.log(fileUpload.files);
  };
}

function main() {
  changeWindow();
  stablishConnection();
  setUpload();
}

main();
