import React, { useState } from 'react';
import axios from 'axios';
function JavaScript() {
  const [searchResults, setSearchResults] = useState([]);
  const language = "JavaScript";
  const handleSubmit = async (event) => {
    event.preventDefault();

    const formData = new FormData(event.target);
    const query = formData.get('query');
    const data ={query,language}

    console.log(data)
    try{
    const response = await axios.post('http://localhost:8000/search',data,{
      headers:{
        'Content-Type': 'application/x-www-form-urlencoded'
      }
    })
    setSearchResults(response.data.results)
  }catch(error){
    console.log(error)
  } 
  };
  return (
    <div>
      <form onSubmit={handleSubmit}>
        <label htmlFor="query">Search: </label>
        <input type="text" id="query" name="query" required />
        <button type="submit">Search</button>
      </form>
      <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Path</th>
          <th>Link</th>
        </tr>
      </thead>
      <tbody>
        {searchResults.map((item) => (
          <tr key={item.path}>
            <td>{item.name}</td>
            <td>{item.path}</td>
            <td><a href={item.html_url} target="_blank" rel="noreferrer">Link</a></td>
          </tr>
        ))}
      </tbody>
    </table>
    </div>
  );
}

export default JavaScript;