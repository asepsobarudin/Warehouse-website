async function get({ url }) {
  try {
    const response = await fetch(url, {
      method: "GET",
    });

    if (!response.ok) {
      console.error(`Network response not OK. Status code: ${response.status}`);
    }

    const result = await response.json();
    return result;
  } catch (error) {
    console.log("Error 500")
  }
}

async function post({ url, data }) {
  const dataToSend = data;
  try {
    const response = await fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": csrfToken.defaultValue
      },
      body: JSON.stringify(dataToSend),
    });

    if (!response.ok) {
      console.error(`Network response not OK. Status code: ${response.status}`);
    }

    const result = await response.json();
    return result;
  } catch (error) {
    console.log("Error 500")
  }
}
