import sys
import json
import logging
from typing import List, Dict

import requests  # type: ignore
from bs4 import BeautifulSoup  # type: ignore
from google.cloud import language_v1


def extraer_contenido(url: str) -> str:
    """
    Extrae el contenido textual de una URL dada.

    Args:
        url (str): La URL de la que se extraerá el contenido.

    Returns:
        str: El texto extraído de la página web.
    """
    try:
        response = requests.get(url)
        response.raise_for_status()
        soup = BeautifulSoup(response.content, 'html.parser')
        texto = soup.get_text(separator=' ', strip=True)
        return texto
    except requests.RequestException as e:
        logging.error(f"Error al obtener el contenido de la URL: {e}")
        sys.exit(1)
    except Exception as e:
        logging.error(f"Error inesperado: {e}")
        sys.exit(1)


def extraer_entidades(texto: str) -> List[Dict[str, float]]:
    """
    Extrae las entidades más relevantes del texto proporcionado utilizando la API de Google Cloud Language.

    Args:
        texto (str): El texto del que se extraerán las entidades.

    Returns:
        List[Dict[str, float]]: Una lista de entidades con sus nombres y niveles de relevancia.
    """
    try:
        client = language_v1.LanguageServiceClient()
        document = language_v1.Document(content=texto, type_=language_v1.Document.Type.PLAIN_TEXT)

        response = client.analyze_entities(request={'document': document})
        
        entidades = [
            {'name': entidad.name, 'salience': entidad.salience}
            for entidad in response.entities
        ]

        entidades = sorted(entidades, key=lambda x: x['salience'], reverse=True)[:5]
        return entidades
    except Exception as e:
        logging.error(f"Error al analizar entidades: {e}")
        sys.exit(1)



def main():
    if len(sys.argv) < 2:
        logging.error("Por favor, proporciona una URL como argumento.")
        sys.exit(1)

    url = sys.argv[1]
    logging.info(f"Extrayendo contenido de la URL: {url}")
    
    texto = extraer_contenido(url)

    if not texto:
        logging.error("No se pudo extraer contenido textual de la URL proporcionada.")
        sys.exit(1)

    entidades = extraer_entidades(texto)
    logging.info(f"Entidades extraídas: {entidades}")

    print(json.dumps(entidades))

if __name__ == "__main__":
    main()
