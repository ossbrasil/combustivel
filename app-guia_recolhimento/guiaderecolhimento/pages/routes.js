import * as React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';

import Login from './Login';
import Home from './Home';
import Checklist from './Checklist';
import Historico from './Historico';
import Abastecimento from './Abastecimento';
import Guia from './Guia';
import Guiaservico from './Guiaservico';
import Assinatura from './Assinatura';
import Placa from './Placa';
import Trocaplaca from './Trocaplaca';


const Stack = createStackNavigator();

function App() {
  return (
    <NavigationContainer>
      <Stack.Navigator  screenOptions ={{headerStyle :{backgroundColor: '#ff5c54'},  headerTintColor:'#fff'}}>
        <Stack.Screen options={{header: () => { false }}} initialRouteName="Login" name="Login" component={Login} />
        <Stack.Screen options={{header: () => { false }}} name="Home" component={Home} />
        <Stack.Screen options={{ headerTitle:'Checklist'}} name="Checklist" component={Checklist} />
        <Stack.Screen options={{ headerTitle:'Histórico'}} name="Historico" component={Historico} />
        <Stack.Screen options={{ headerTitle:'Abastecimento'}} name="Abastecimento" component={Abastecimento} />
        <Stack.Screen options={{ headerTitle:'Informações da guia'}} name="Guia" component={Guia} />
        <Stack.Screen options={{ headerTitle:'Guia em serviço'}} name="Guiaservico" component={Guiaservico} />
        <Stack.Screen options={{ headerTitle:'Coleta de assinatura'}} name="Assinatura" component={Assinatura} />
        <Stack.Screen options={{ headerTitle:'Alteração de carro'}} name="Trocaplaca" component={Trocaplaca} />
        <Stack.Screen options={{ header: () => { false }}} name="Placa" component={Placa} />
      </Stack.Navigator>
    </NavigationContainer>
  );
}

export default App;