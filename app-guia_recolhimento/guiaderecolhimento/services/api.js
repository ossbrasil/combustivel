import axios from 'axios'

const api = axios.create({
    baseURL: 'http://fvblocadora.com.br/FVB/web_services/ws-apiGuiaRecolhimento.php'
 });
 
 export default api;