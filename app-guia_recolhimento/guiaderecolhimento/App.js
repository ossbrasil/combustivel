import React from 'react';
import { StatusBar } from 'react-native';
import Routes from './pages/routes';


export default function App() {
  return (
    <> 
      <StatusBar barStyle="light-content" backgroundColor="#0B8D47" />
      
      <Routes />
    </>
  );
} 

