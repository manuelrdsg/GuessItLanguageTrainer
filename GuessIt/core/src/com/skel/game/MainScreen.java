package com.skel.game;

import com.badlogic.gdx.Game;
import com.badlogic.gdx.Gdx;
import com.badlogic.gdx.Input;
import com.badlogic.gdx.Screen;
import com.badlogic.gdx.graphics.GL20;
import com.badlogic.gdx.graphics.g2d.BitmapFont;
import com.badlogic.gdx.scenes.scene2d.InputEvent;
import com.badlogic.gdx.scenes.scene2d.InputListener;
import com.badlogic.gdx.scenes.scene2d.Stage;
import com.badlogic.gdx.scenes.scene2d.actions.Actions;
import com.badlogic.gdx.scenes.scene2d.ui.Label;
import com.badlogic.gdx.scenes.scene2d.ui.Skin;
import com.badlogic.gdx.scenes.scene2d.ui.TextButton;
import com.badlogic.gdx.scenes.scene2d.utils.ClickListener;
import com.badlogic.gdx.utils.Align;
import com.badlogic.gdx.utils.viewport.FillViewport;
import com.badlogic.gdx.utils.viewport.StretchViewport;
import com.skel.util.HintSpeech;
import com.skel.util.Utils;

public class MainScreen implements Screen {

	Utils utilidades = new Utils();

	Skin skin;
	Stage stage;

	MainGame g;

	//Items del screen
	TextButton newGameButton;
	TextButton aboutButton;
	TextButton registerButton;
	TextButton notebookButton;
	Label lab;

	private HintSpeech toSpeech;

	public MainScreen(MainGame g, HintSpeech toSpeech){
		create();
		this.g = g;
		this.toSpeech = toSpeech;
	}

	public MainScreen(){
		create();
	}

	public void createStageActors(){
		//Create button login
		newGameButton = new TextButton("Login",skin);
		aboutButton = new TextButton("Credits",skin);
		registerButton = new TextButton("Register",skin);
		notebookButton = new TextButton("Notebook", skin.get("default", TextButton.TextButtonStyle.class));
		lab = new Label("",skin.get("logo", Label.LabelStyle.class)); //Tomar como ejemplo para seleccionar skins diferentes.

		// Posicionamiento
		newGameButton.setBounds(Gdx.graphics.getWidth()*0.1f, Gdx.graphics.getHeight()*0.5f,Gdx.graphics.getWidth()*0.8f,Gdx.graphics.getHeight()*0.1f);

		registerButton.setBounds(Gdx.graphics.getWidth()*0.1f, Gdx.graphics.getHeight()*0.4f,Gdx.graphics.getWidth()*0.8f,Gdx.graphics.getHeight()*0.1f);

		aboutButton.setBounds(Gdx.graphics.getWidth()*0.1f, Gdx.graphics.getHeight()*0.3f,Gdx.graphics.getWidth()*0.8f,Gdx.graphics.getHeight()*0.1f);

		notebookButton.setBounds(Gdx.graphics.getWidth()*0.1f, Gdx.graphics.getHeight()*0.2f,Gdx.graphics.getWidth()*0.8f,Gdx.graphics.getHeight()*0.1f);

		lab.setBounds(Gdx.graphics.getWidth()*0.2f, Gdx.graphics.getHeight()*0.6f,Gdx.graphics.getWidth()*0.6f,Gdx.graphics.getHeight()*0.4f);

		//Activar caracteristicas
		lab.setWrap(true);
		lab.setAlignment(Align.center);

		// Funciones callback

		newGameButton.addListener(new ClickListener() {
			public void clicked(InputEvent event, float x, float y) {
				g.setScreen(new LoginScreen(g, skin, toSpeech));
				dispose();
			}
		});

		registerButton.addListener(new ClickListener() {
			public void clicked(InputEvent event, float x, float y) {
				g.setScreen(new RegisterScreen(g, skin, toSpeech));
				dispose();
			}
		});

		notebookButton.addListener(new ClickListener() {
			public void clicked(InputEvent event, float x, float y) {
				g.setScreen(new NoteBookScreen(g, skin, toSpeech));
				dispose();
			}
		});

		aboutButton.addListener(new ClickListener() {
			public void clicked(InputEvent event, float x, float y) {
				g.setScreen(new CreditsScreen(g, skin, toSpeech));
				dispose();
			}
		});

		// Anadir al stage
		stage.addActor(aboutButton);
		stage.addActor(newGameButton);
		stage.addActor(registerButton);
		stage.addActor(notebookButton);
		stage.addActor(lab);
	}

	public void create () {
		stage = new Stage(new FillViewport(Gdx.graphics.getWidth(),Gdx.graphics.getHeight()));
		Gdx.input.setInputProcessor(stage);
		Gdx.input.setCatchBackKey(false);
		//Setting up Basic Skin (default skin)
		skin = utilidades.createBasicSkin();

		createStageActors();
	}

	@Override
	public void render (float delta) {
		Gdx.gl.glClear(GL20.GL_COLOR_BUFFER_BIT);
		Gdx.gl.glClearColor(0.95f, 0.95f, 0.95f, 1);
		stage.act(delta);
		stage.draw();
	}

	@Override
	public void show() {

	}

	public void resize(int width, int height){
		stage.getViewport().update(width, height, false);
	}

	@Override
	public void pause() {

	}

	@Override
	public void resume() {

	}

	@Override
	public void hide() {

	}

	@Override
	public void dispose() {
		stage.dispose();
		//skin.dispose();
	}
}
