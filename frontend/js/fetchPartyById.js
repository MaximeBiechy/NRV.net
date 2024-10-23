async function fetchPartyById(id) {
    try {
      const response = await fetch(`http://localhost:21000/parties/${id}`,{ headers: { 'Origin': 'http://localhost' }});
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      const data = await response.json();
      console.log(data);
      return data;
    }
    catch (error) {
      console.error('There has been a problem with your fetch operation:', error);
    }
  }
  

  
(async () => {
    const data = await fetchPartyById('a0b7566b-6fdd-4e34-bbab-41d882de9c07');
    let new_date = new Date(data.party.date.date).toLocaleDateString('fr-FR', { weekday: 'short', day: '2-digit', month: '2-digit' });
    data.party.date.date = new_date;
  
    let new_date_begin = new Date(data.party.begin.date).toLocaleDateString('fr-FR', { weekday: 'long', day: '2-digit', month: '2-digit' });
    data.party.begin.date = new_date_begin;
    fillPartyTemplate(data);
    //loader.style.display = 'none'
  })();