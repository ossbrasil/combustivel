import * as React from 'react';
import { TouchableOpacity, BackHandler, View, Text, Alert, ScrollView } from 'react-native';
import { Spinner, Content, Drawer } from 'native-base';
import styles from '../estilo/style'
import Sidebar from '../components/sidebar'
import Icon from 'react-native-vector-icons/MaterialIcons'
import Icone from 'react-native-vector-icons/FontAwesome'
import Icones from 'react-native-vector-icons/Ionicons'
import api from '../services/api'
import AsyncStorage from '@react-native-community/async-storage';


class Historico extends React.PureComponent {
    constructor(props) {
        super(props);
        this.state = {
            estado: 0,
            guias: [],
            selectedItem: '',
            infoGuia: 0,
            infoGuiaServico: 0,
            carregando: 0,
            carregandoServico: 0,
        }
        // this.atualizarServico()
        this.carrega_infos()
    }

    closeDrawer = () => {
        this.drawer._root.close()
      }
      openDrawer = () => {
        this.drawer._root.open()
      }

    carrega_infos = async () => {
        const dadosMot = await AsyncStorage.getItem('dadosMot')

        var jResponse = JSON.parse(dadosMot)

        var matricula = jResponse.matricula
        var nome = jResponse.nome
        var cnh = jResponse.cnh

        const infoCarro = await AsyncStorage.getItem('infoCarro')

        var jResponse = JSON.parse(infoCarro)

        var placa = jResponse.placa
        var modelo = jResponse.modelo
        var contrato = jResponse.contrato

        // Alert.alert("Teste", matricula)

        this.setState({
            matricula: matricula,
            nome: nome,
            cnh: cnh,
            placa: placa,
            modelo: modelo,
            contrato: contrato,
        })

        this.atualizarServico()
    }

    atualizarServico = async () => {
        // Alert.alert("Teste")

        this.setState({
            estado: 0,
            infoGuiaServico: 0,
            carregando: 0,
            carregandoServico: 0
        })

        this.timer = setTimeout(() => {
            this.servico();
        }, 500)
    }

    servico = async () => {
        // Alert.alert("1")
        try {
            // const response = await api.post('/consultaGuias/')
            const response = await api.post('/consultaGuias/', {
                "matricula": this.state.matricula,
                "placa": this.state.placa
            })

            var jResponse = JSON.stringify(response.data)

            console.log(jResponse)

            // Alert.alert("Teste", jResponse)

            if (jResponse == '"Não existem Guias de Recolhimento para esse motorista"') {
                // Alert.alert("Teste", jResponse)
                this.setState({
                    estado: 0,
                    carregandoServico: 1,
                    infoGuiaServico: 0,
                })
            } else {
                var jResponse = JSON.parse(jResponse)

                this.setState({
                    estado: 0,
                    guias: jResponse,
                    carregandoServico: 1,
                    infoGuiaServico: 1
                })
            }


        } catch (error) {
            Alert.alert("Erro de conexão")
            this.setState({
                estado: 0,
                carregandoServico: 1,
                infoGuiaServico: 0,
            })
        }
    }



    atualizarFinalizadas = async () => {
        // Alert.alert("Teste 2")

        this.setState({
            estado: 1,
            infoGuia: 0,
            carregando: 0,
            carregandoServico: 0
        })

        this.timer = setTimeout(() => {
            this.finalizadas();
        }, 500)
    }

    finalizadas = async () => {
        // Alert.alert('2')

        try {
            const response = await api.post('/consultaGuiasFinalizadas/', {
                "matricula": this.state.matricula,
                "placa": this.state.placa
            })

            var jResponse = JSON.stringify(response.data)

            console.log(jResponse)

            // Alert.alert("Teste", jResponse)

            if (jResponse == '"Não existe um histórico de guias para esse motorista"') {
                // Alert.alert("Teste", jResponse)
                this.setState({
                    estado: 1,
                    carregando: 1,
                    infoGuia: 0,
                })
            } else {
                var jResponse = JSON.parse(jResponse)

                this.setState({
                    estado: 1,
                    guias: jResponse,
                    carregando: 1,
                    infoGuia: 1
                })
            }


        } catch (error) {
            Alert.alert("Erro de conexão")
            this.setState({
                estado: 1,
                carregando: 1,
                infoGuia: 0,
            })
        }
    }

    consultaGuiaservico = async (id) => {
        // Alert.alert('Teste', id)
        await AsyncStorage.setItem('idGuia', id)

        this.props.navigation.navigate('Guiaservico');
    }

    consultaGuia = async (id) => {
        // Alert.alert('Teste', id)
        await AsyncStorage.setItem('idGuia', id)

        this.props.navigation.navigate('Guia');
    }

    render() {
        return (
            <Drawer
            ref={(ref) => { this.drawer = ref; }}
            content={<Sidebar navigation={this.props.navigation} />}
            onClose={() => this.closeDrawer()}>
                <View style={styles.backgroundHistorico}>
                    <Text style={{ fontSize: 20, padding: 15 }}>Histórico de Guias</Text>

                    {(this.state.estado == 0)
                        ?
                        <View style={styles.cardGuia}>
                            {(this.state.infoGuiaServico == 0)
                                ?
                                <View style={styles.background}>
                                    <View style={{ flexDirection: 'row', justifyContent: 'space-between' }}>
                                        <TouchableOpacity style={styles.btnServicos} onPress={this.atualizarServico.bind(this)}>
                                            <Text style={{ color: '#ff5c54', paddingBottom: 10 }}>EM SERVIÇO</Text>
                                            <View style={styles.lineHistorico} />
                                        </TouchableOpacity>
                                        <TouchableOpacity style={styles.btnServicos} onPress={this.atualizarFinalizadas.bind(this)}>
                                            <Text style={{ color: 'black', paddingBottom: 10 }}>FINALIZADAS</Text>
                                            <View style={styles.lineCinza} />
                                        </TouchableOpacity>
                                    </View>
                                    {(this.state.carregandoServico == 0)
                                        ?

                                        <View style={styles.background}>
                                            <Text style={{ fontSize: 26 }}>Carregando</Text>
                                            <Spinner color='#ff5c54' />
                                        </View>

                                        :
                                        <View style={styles.background}>
                                            <View style={{ padding: 50 }}>
                                                <Text style={{ fontSize: 16, textAlign: 'justify' }}>No momento não existem guias de recolhimento ativas para o veículo informado</Text>
                                            </View>
                                            <TouchableOpacity style={{ padding: 5 }}>
                                                <Icones name={'ios-reload-circle-sharp'} size={80} color={'#ff5c54'} onPress={this.atualizarServico} />
                                            </TouchableOpacity>

                                        </View>
                                    }
                                </View>
                                :
                                <View style={{flex: 1}}>
                                    <View style={{ flexDirection: 'row', justifyContent: 'space-between' }}>
                                        <TouchableOpacity style={styles.btnServicos} onPress={this.atualizarServico.bind(this)}>
                                            <Text style={{ color: '#ff5c54', paddingBottom: 10 }}>EM SERVIÇO</Text>
                                            <View style={styles.lineHistorico} />
                                        </TouchableOpacity>
                                        <TouchableOpacity style={styles.btnServicos} onPress={this.atualizarFinalizadas.bind(this)}>
                                            <Text style={{ color: 'black', paddingBottom: 10 }}>FINALIZADAS</Text>
                                            <View style={styles.lineCinza} />
                                        </TouchableOpacity>
                                    </View>
                                    
                                    <ScrollView >

                                        {
                                            this.state.guias.map((item) => {
                                                return (
                                                    <TouchableOpacity onPress={this.consultaGuiaservico.bind(this, item.id)}>
                                                        <View style={{ padding: 5, paddingLeft: 10, flexDirection: 'row', justifyContent: 'space-between' }} >
                                                            <View>
                                                                <View style={{ flexDirection: 'row' }}>
                                                                    <Text>Local</Text>
                                                                    <Icon name={'location-on'} size={18} color="#C0C0C0" style={{ paddingLeft: 5 }} />
                                                                </View>
                                                                <Text>{item.rua} - {item.numero}</Text>
                                                                <Text>{item.bairro}</Text>
                                                                <Text>Aguardando coleta</Text>
                                                            </View>
                                                            <View style={{ justifyContent: 'center', padding: 15 }}>
                                                                <Icone name={'file-text'} size={35} color="#ff5c54" />
                                                            </View>
                                                        </View>
                                                        <View style={styles.lineCinza} />
                                                    </TouchableOpacity>
                                                )
                                            })}
                                    </ScrollView>
                                    
                                </View>
                            }

                        </View>

                        :
                        <View style={styles.cardGuia}>
                            {(this.state.infoGuia == 0)
                                ?
                                <View style={styles.background}>
                                    <View style={{ flexDirection: 'row', justifyContent: 'space-between' }}>
                                        <TouchableOpacity style={styles.btnServicos} onPress={this.atualizarServico.bind(this)}>
                                            <Text style={{ color: 'black', paddingBottom: 10 }}>EM SERVIÇO</Text>
                                            <View style={styles.lineCinza} />
                                        </TouchableOpacity>
                                        <TouchableOpacity style={styles.btnServicos}>
                                            <Text style={{ color: '#ff5c54', paddingBottom: 10 }} onPress={this.atualizarFinalizadas.bind(this)}>FINALIZADAS</Text>
                                            <View style={styles.lineHistorico} />
                                        </TouchableOpacity>
                                    </View>
                                    {(this.state.carregando == 0)
                                        ?

                                        <View style={styles.background}>
                                            <Text style={{ fontSize: 26 }}>Carregando</Text>
                                            <Spinner color='#ff5c54' />
                                        </View>

                                        :
                                        <View style={styles.background}>
                                            <View style={{ padding: 50 }}>
                                                <Text style={{ fontSize: 16, textAlign: 'justify' }}>Não existe um histórico de guias de recolhimento para o veículo informado</Text>
                                            </View>
                                            <TouchableOpacity style={{ padding: 5 }}>
                                                <Icones name={'ios-reload-circle-sharp'} size={80} color={'#ff5c54'} onPress={this.atualizarFinalizadas} />
                                            </TouchableOpacity>
                                        </View>
                                    }
                                </View>
                                :
                                <View style={{flex: 1}}>
                                    <View style={{ flexDirection: 'row', justifyContent: 'space-between' }}>
                                        <TouchableOpacity style={styles.btnServicos} onPress={this.atualizarServico.bind(this)}>
                                            <Text style={{ color: 'black', paddingBottom: 10 }}>EM SERVIÇO</Text>
                                            <View style={styles.lineCinza} />
                                        </TouchableOpacity>
                                        <TouchableOpacity style={styles.btnServicos}>
                                            <Text style={{ color: '#ff5c54', paddingBottom: 10 }} onPress={this.atualizarFinalizadas.bind(this)}>FINALIZADAS</Text>
                                            <View style={styles.lineHistorico} />
                                        </TouchableOpacity>
                                    </View>
                                    <ScrollView style={{ flex: 1 }}>
                                        {
                                            this.state.guias.map((item) => {
                                                return (
                                                    <TouchableOpacity onPress={this.consultaGuia.bind(this, item.id)}>
                                                        <View style={{ padding: 5, paddingLeft: 10, flexDirection: 'row', justifyContent: 'space-between' }} >
                                                            <View>
                                                                <View style={{ flexDirection: 'row' }}>
                                                                    <Text>Local</Text>
                                                                    <Icon name={'location-on'} size={18} color="#C0C0C0" style={{ paddingLeft: 5 }} />
                                                                </View>
                                                                <Text>{item.rua} - {item.numero}</Text>
                                                                <Text>{item.bairro}</Text>
                                                            </View>
                                                            <View style={{ justifyContent: 'center', padding: 15 }}>
                                                                <Icone name={'file-text'} size={35} color="#ff5c54" />
                                                            </View>
                                                        </View>
                                                        <View style={styles.lineCinza} />
                                                    </TouchableOpacity>
                                                )
                                            })}
                                    </ScrollView>
                                </View>
                            }

                        </View>
                    }

                    <View style={{ flex: 1 }} />
                    <View style={styles.footer}>
                        <TouchableOpacity style={{ padding: 5 }}>
                            <Icon name={'menu'} size={40} color={'white'} onPress={this.openDrawer} />
                        </TouchableOpacity>
                    </View>
                </View>
            </Drawer>
        );
    }
}

export default Historico;
