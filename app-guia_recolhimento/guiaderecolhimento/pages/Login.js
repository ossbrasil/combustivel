import React from 'react';
import { ImageBackground, Alert, Dimensions, PermissionsAndroid, Platform } from 'react-native';
import { Container, Button, Text, Form, Item, Input, Label, View } from 'native-base';
import styles from '../estilo/style'
import api from '../services/api'
import AsyncStorage from '@react-native-community/async-storage';

class Login extends React.Component {
    constructor(props) {
        super(props)

        this.state = {
            matricula: '',
            senha: '',
            orientatio: ''
        }
        this.checkAndroidPermission()
    }

    checkAndroidPermission = async () => {
        // const realm = await getRealm()
        //   await AsyncStorage.multiRemove(['allFotos'])

        if (Platform.OS === 'android') {
            try {

                // PermissionsAndroid.requestMultiple([PermissionsAndroid.PERMISSIONS.READ_EXTERNAL_STORAGE,PermissionsAndroid.PERMISSIONS.WRITE_EXTERNAL_STORAGE, PermissionsAndroid.PERMISSIONS.CAMERA])

                await PermissionsAndroid.request(PermissionsAndroid.PERMISSIONS.WRITE_EXTERNAL_STORAGE);
                // const permission = PermissionsAndroid.PERMISSIONS.WRITE_EXTERNAL_STORAGE;
                // await PermissionsAndroid.request(permission);

                await PermissionsAndroid.request(PermissionsAndroid.PERMISSIONS.CAMERA);
                // const permission2 = PermissionsAndroid.PERMISSIONS.CAMERA;
                // await PermissionsAndroid.request(permission2);

                await PermissionsAndroid.request(PermissionsAndroid.PERMISSIONS.READ_EXTERNAL_STORAGE);
                // const permission3 = PermissionsAndroid.PERMISSIONS.READ_EXTERNAL_STORAGE;
                // await PermissionsAndroid.request(permission3);

                Promise.resolve();
                // this.populaBanco()
            } catch (error) {
                Promise.reject(error);
            }
        }

    };

    // populaBanco = async () => {
    //     const realm = await getRealm()
    //     try {
    //         const responseMot = await api.get('/listaMotoristas/')
    //         responseMot.data.array1.map((item) => {
    //             // console.log(item)
    //             realm.write(() => {
    //                 realm.create('Motoristas', {
    //                     id: Number(item.id),
    //                     nome: item.nome,
    //                     cnh: item.cnh,
    //                     validade_cnh: item.validade_cnh,
    //                     funcao: item.funcao,
    //                     cpf: item.cpf,
    //                     rg: item.rg,
    //                     foto: item.foto
    //                 },
    //                     'modified');
    //             });
    //         })

    //         responseMot.data.array2.map((item) => {
    //             // console.log(item)
    //             realm.write(() => {
    //                 realm.create('NomesMotoristas', {
    //                     id: Number(item.id),
    //                     NomeMot: item.nome

    //                 },
    //                     'modified');
    //             });
    //         })

    //     } catch (error) {
    //         console.log(error)
    //         console.log("erro de conexão")
    //     }


    //     try {
    //         const responsePlacas = await api.get('/listarPlacas/')
    //         responsePlacas.data.map((item) => {
    //             realm.write(() => {
    //                 realm.create('Placas', {
    //                     id: Number(item.id),
    //                     placa: item.placa
    //                 },
    //                     'modified');
    //             });
    //         })
    //     } catch (error) {
    //         console.log("erro de conexão")
    //     }


    // }


    onLayout() {
        const { width, height } = Dimensions.get('window')
        if (width > height) {

            this.setState({
                orientatio: 'Landscape'
            })
        }
        else {
            this.setState({
                orientatio: 'Portrait'
            })
        }
    }

    login = async () => {
        //Verifica se os campos estão vazios
        if (!this.state.matricula || !this.state.senha) {
            Alert.alert('Preencha todos os campos!');
        } else {
            try {
                const response = await api.post('/authenticate/', {
                    "matricula": this.state.matricula,
                    "senha": this.state.senha
                })


                var autenticacao = response.data.autenticacao;

                if (autenticacao == 1) {

                    setTimeout(async () => {
                        var jsonDadosGerais = {
                            "tokem": response.data.token,
                            "nome": response.data.nome,
                            "cnh": response.data.cnh,
                            "matricula": this.state.matricula
                        }
                        await AsyncStorage.setItem('dadosMot', JSON.stringify(jsonDadosGerais))
                        // Alert.alert(response.data.token)
                    }, 1000)


                    
                    await AsyncStorage.setItem('contGuia', "0")
                    this.props.navigation.navigate('Placa');
                    // await this.props.navigation.navigate('Home');


                } else if (autenticacao == 0) {
                    Alert.alert('Login ou Senha Inválidos!');
                } else {
                    Alert.alert('Erro no Login, tente novamente mais tarde!');
                }

            } catch (error) {
                // console.log(loginOff)
                Alert.alert('Erro no  login, verifique sua conexão!');
            }
        }
    };

    componentDidMount = () => {
        this.onLayout()
    }

    render() {
        return (
            <Container>
                <ImageBackground
                    onLayout={() => this.onLayout()}
                    imageStyle={[(this.state.orientatio == 'Portrait') ? { resizeMode: "cover" } : {}]}
                    source={(this.state.orientatio == 'Portrait') ? require('../assets/teste5.png') : require('../assets/background.png')}
                    style={styles.background}
                >

                    {/* <Text>Login</Text> */}
                    <Form style={[{ justifyContent: 'center' }, (this.state.orientatio == 'Portrait') ? { marginTop: 150 } : { marginTop: 0 }]} >

                        <View style={{ height: 50 }}></View>
                        <Text
                            style={styles.labelTxtLogin}
                        >LOGIN</Text>
                        <Text
                            style={styles.labelTxtLogin}
                        >GUIAS DE RECOLHIMENTO</Text>
                        <Item
                            floatingLabel
                            stackedLabel
                            style={styles.arrumaInput}
                        >
                            <Label
                                style={styles.labelLogin}
                            >Matrícula</Label>
                            <Input
                                keyboardType={'number-pad'}
                                returnKeyLabel={"next"}
                                style={[styles.inputLogin, (this.state.orientatio == 'Portrait') ? {} : { color: '#000' }]}
                                onChangeText={(text) => this.setState({ matricula: text })}
                            />
                        </Item>
                        <Item
                            floatingLabel
                            stackedLabel
                            style={styles.arrumaInput}
                        >
                            <Label
                                style={styles.labelLogin}
                            >Senha</Label>
                            <Input
                                keyboardType={'number-pad'}
                                secureTextEntry={true}
                                returnKeyLabel={"next"}
                                style={styles.inputLogin}
                                onChangeText={(text) => this.setState({ senha: text })}
                            />
                        </Item>
                        <Button
                            bordered
                            light
                            style={styles.btnLogin}
                            onPress={this.login}
                        >
                            <Text
                                style={styles.txtLogin}
                            >Login</Text>
                        </Button>
                    </Form>

                </ImageBackground>
            </Container>

        );
    }
}

export default Login;